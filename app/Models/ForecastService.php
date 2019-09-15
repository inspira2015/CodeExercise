<?php
    
    
    namespace App\Models;
    
    use App\Models\ForecastRepository;
    use App\Models\ForecastReader;
    use Illuminate\Support\Facades\Date;


    class ForecastService
    {
        protected static $forecastReader;
        protected $hoursToCheck;
        
        public function __construct(ForecastReader $forecastReader)
        {
            self::$forecastReader = $forecastReader;
            $this->hoursToCheck = 4;
        }
    
        public function saveForecastForALocation($latitude, $longitude)
        {
            $location = ForecastRepository::findOrCreateLocation($latitude, $longitude);
            $now = date('Y-m-d G:i:s');
            
            if ($this->checkForecast($location->last_forecast_update, $now)) {
                $forecastArray = self::$forecastReader->readForecastByLocation($latitude, $longitude);
                $temp = $this->prepareForecastForInsert([$forecastArray], ['locations_id' => $location->id]);
                ForecastRepository::saveForecasts($temp);
                $location->last_forecast_update = $now;
                $location->save();
            }
        }
        
        protected function prepareForecastForInsert(Array $forecastArray, Array $locationId)
        {
            return array_map(function($forecast, $locationId) {
                $temp = array_merge(
                                     $forecast, [
                                                    'precipitation_intensity' => $forecast['precipIntensity'],
                                                    'precipitation_probability' => $forecast['precipProbability']
                                                ]
                                    );
                unset($temp['precipIntensity']);
                unset($temp['precipProbability']);
                return array_merge($temp, $locationId);
            }, $forecastArray, [$locationId]);
        }
        
        protected function checkForecast($lastTime, $newTime)
        {
            $unixLastTime = new \DateTime($lastTime);
 
            $unixNewTime  = new \DateTime($newTime);
            $unixNewTime->setTimezone(new \DateTimeZone("UTC"));
            
            $unixLastTime->add($this->getValidInterval());
            $unixLastTime->setTimezone(new \DateTimeZone("UTC"));

            $unixLast = (int) $unixLastTime->getTimestamp();
            $unixNow = (int) $unixNewTime->getTimestamp();
            
            if ($unixLast < $unixNow) {
                return true;
            }
    
            return false;
        }
        
        protected function getValidInterval()
        {
            return new \DateInterval('PT' . $this->hoursToCheck . 'H');
        }
        
    }
