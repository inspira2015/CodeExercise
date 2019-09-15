<?php
    
    namespace App\Models;
    
    use App\Models\Forecasts;
    use App\Models\Locations;
    
    class ForecastRepository
    {
    
        public static function saveForecasts(Array $forecasts)
        {
            foreach ($forecasts as $key => $value) {
                Forecasts::create($value);
            }
        }
        
        public static function createLocation(int $latitude, int $longitude)
        {
            $newLocation = new Locations();
            $newLocation->latitude = $latitude;
            $newLocation->longitude = $longitude;
            $newLocation->save();
            return $newLocation;
        }
        
        public static function findOrCreateLocation(int $latitude, int $longitude)
        {
            $location = Locations::where('latitude', '=', $latitude)
                                   ->where('longitude', '=', $longitude)
                                   ->first();
            
            if ($location !== null) {
                return $location;
            }
            return self::createLocation($latitude,$longitude);
        }
    
        public function findForecastsByLocationIdAfter(int $locationId, int $epoch)
        {
            return Forecasts::GetForecastByLocIdAndTime($locationId, $epoch);
        }
    }
