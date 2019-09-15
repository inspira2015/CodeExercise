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
    
    }
