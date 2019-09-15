<?php
    
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use DB;
    
    class Forecasts extends Model
    {
        protected $table = 'forecasts';

        public $timestamps = false;
    
        protected $fillable = [
                                'locations_id',
                                'time',
                                'temperature',
                                'precipitation_intensity',
                                'precipitation_probability',
                              ];
    
        public function scopeGetForecastByLocIdAndTime($query, $locationId, $time)
        {
            return $query->select('forecasts.*')
                         ->join('locations', 'locations.id',  '=', 'forecasts.locations_id')
                         ->where('locations.id', '=', $locationId)
                         ->where('forecasts.time', '>', $time)
                         ->get();
        }
    }
