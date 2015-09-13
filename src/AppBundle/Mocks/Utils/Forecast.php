<?php

namespace AppBundle\Mocks\Utils;

class Forecast
{
    public function fetch()
    {
        return array(
            'time' => time(),
            'summary' => 'Mostly Cloudy',
            'icon' => 'partly-cloudy-day',
            'sunriseTime' => 0,
            'sunsetTime' => 0,
            'precipIntensity' => 0,
            'precipIntensityMax' => 0,
            'precipIntensityMaxTime' => 0,
            'precipProbability' => 0,
            'precipType' => '',
            'precipAccumulation' => 0,
            'temperature' => 15.960000000000001,
            'temperatureMin' => 0,
            'temperatureMinTime' => 0,
            'temperatureMax' => 0,
            'temperatureMaxTime' => 0,
            'apparentTemperature' => 15.960000000000001,
            'dewPoint' => 11.529999999999999,
            'windSpeed' => 10.93,
            'windBearing' => 239,
            'cloudCover' => 0.68000000000000005,
            'humidity' => 0.75,
            'pressure' => 997.59000000000003,
            'visibility' => 14.789999999999999,
            'ozone' => 323.52999999999997,
            'moonPhase' => 0,
        );
    }
}
