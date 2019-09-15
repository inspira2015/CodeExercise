<?php
    
    
    namespace App\Models;
    use App\Models\Forecasts;
    use App\Models\Locations;
    
    
    
    class ForecastRepository
    {
    
        public function saveForecasts(Array $forecasts)
        {
            foreach ($forecasts as $key => $value) {
            
            }
        }
        
        public static function createLocation($latitude, $longitude)
        {
            $newLocation = new Locations();
            $newLocation->latitude = $latitude;
            $newLocation->longitude = $longitude;
            $newLocation->save();
            return $newLocation->id;
        }
        
    }
