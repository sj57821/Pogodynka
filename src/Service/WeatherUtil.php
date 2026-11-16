<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    public function __construct(
        private MeasurementRepository $measurementRepository,
        private LocationRepository $locationRepository,
    ) {}

    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $cityName): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $cityName,
        ]);

        if (!$location) {
            return [];
        }

        return $this->getWeatherForLocation($location);
    }
}
