<?php

namespace AppBundle\Utils;

use Doctrine\Common\Cache\Cache;

class Forecast
{
    const CACHE_KEY = 'forecast_ws_result';

    private $baseUrl;
    private $cache;

    public function __construct($baseUrl = 'http://localhost', Cache $cache)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->cache = $cache;
    }

    public function fetch()
    {
        if (false === $data = $this->cache->fetch(self::CACHE_KEY)) {
            $data = file_get_contents(sprintf('%s/forecast', $this->baseUrl));

            // store in cache for 15 minutes.
            $this->cache->save(self::CACHE_KEY, $data, 900);
        }

        return json_decode($data, true);
    }
}
