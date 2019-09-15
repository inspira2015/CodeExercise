<?php
    
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use DB;
    
    class Forecasts extends Model
    {
        protected $table = 'forecasts';

        public $timestamps = false;
    }
