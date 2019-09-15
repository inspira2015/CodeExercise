<?php

// Read from API

namespace App\Models;

use App\Traits\TraitSafeMergePaths;

class ForecastReader
{
    use TraitSafeMergePaths;

    protected $apiUrl;
    protected $apiKey;
    protected $mask;

    public function __construct(Array $apiDetails, Array $mask)
    {
        $this->apiUrl = $apiDetails['apiUrl'];
        $this->apiKey = $apiDetails['apiKey'];
        $this->mask   = $mask;
    }

    public function readForecastByLocation($latitude, $longitude)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $this->buildUrl($latitude, $longitude),
        ]);
        $restResponse = $this->convertToArray(curl_exec($curl));
        curl_close($curl);
        return $this->getForecastResponseWithMask((Array) $restResponse->currently);
    }

    protected function buildUrl($latitude, $longitude)
    {
        $location = $latitude . ',' . $longitude;
        return $this->safeMergePaths($this->safeMergePaths($this->apiUrl, $this->apiKey), $location);
    }

    protected function convertToArray($response)
    {
        return json_decode($response);
    }
    
    protected function getForecastResponseWithMask($restResponse)
    {
        $resultArray = [];
        foreach ($this->mask as $key => $value) {
            $resultArray[$value] = $restResponse[$value];
        }
        return $resultArray;
    }
}
