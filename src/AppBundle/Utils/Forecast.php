<?php

namespace AppBundle\Utils;

class Forecast
{
    private $baseUrl;

    public function __construct($baseUrl = 'http://localhost')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function fetch()
    {
        $data = file_get_contents(sprintf('%s/forecast', $this->baseUrl));

        return json_decode($data, true);
    }
}
