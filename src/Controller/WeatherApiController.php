<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil                            $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string    $city,
        #[MapQueryParameter('format')] string  $format = 'json',
        #[MapQueryParameter('twig')] bool      $twig = false
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if ($format === 'json') {
            if ($twig) {
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            } else {
                return $this->json([
                    'city' => $city,
                    'country' => $country,
                    'measurements' => array_map(fn(Measurement $m) => [
                        'date' => $m->getDatetime()->format('Y-m-d'),
                        'celsius' => $m->getTemperature(),
                        'fahrenheit' => $m->getFahrenheit()
                    ], $measurements)
                ]);
            }
        } else if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);

            } else {
                $csvTemplate = "City,Country,Date,Celsius,Fahrenheit\n";
                $csvTemplate .= implode(
                    "\n",
                    array_map(fn(Measurement $m) => sprintf(
                        '%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDatetime()->format('Y-m-d'),
                        $m->getTemperature(),
                        $m->getFahrenheit()
                    ), $measurements)
                );
                return new Response($csvTemplate);
            }
        } else {
            return $this->json(['message' => 'You choose wrong format. Valid formats: json and csv']);
        }
    }
}
