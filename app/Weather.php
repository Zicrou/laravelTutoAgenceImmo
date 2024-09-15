<?php

namespace App;

use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;

class Weather
{
    public function __construct(private Repository $cache) {
       
    }
    public function isSunnyTomorrow(): bool
    {
        $result = $this->cache->get('weather');
        // Ou bien 
        //$result = Cache::get('weather');
        
        if ($result !== null) {
            return $result;
        }
        return true;
    }
}