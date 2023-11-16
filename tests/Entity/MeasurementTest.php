<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['-21', -5.8],
            ['12', 53.6],
            ['3.3', 37.94],
            ['0.5', 32.9],
            ['-0.5', 31.1],
            ['2.1', 35.78],
            ['21.3', 70.34],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
//        $celsiusTestData = [0, -100, 100];
//        $fahrenheitTestData = [32, -148, 212];

        $m = new Measurement();

        $m->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $m->getFahrenheit());

//        $m->setTemperature($celsius);
//        $this->assertEquals($expectedFahrenheit, $m->getFahrenheit());
//
//        $m->setTemperature($celsius);
//        $this->assertEquals($expectedFahrenheit, $m->getFahrenheit());
    }
}
