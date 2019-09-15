<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForecastReader;
use App\Models\ForecastRepository;
use App\Models\ForecastService;
use View;
use Session;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiDetails = [
                        'apiUrl' => 'https://api.darksky.net/forecast/',
                        'apiKey' => 'f9becf31ab9b36609ebee33a76c27344'
                      ];
        $mask = [
                'time',
                'temperature',
                'precipIntensity',
                'precipProbability'
            ];
        
        
        $latitude = 37.8267;
        $longitude = -122.4234;
    
        $reader = new ForecastReader($apiDetails, $mask);
        $forecastService = new ForecastService($reader);
        
        $locationId = $forecastService->saveForecastForALocation($latitude,$longitude);
        
        if ($locationId == false) {
            
        }

     
    }

}