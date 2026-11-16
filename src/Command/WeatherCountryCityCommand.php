<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Pobiera prognozę pogody dla kraju i miasta',
)]
class WeatherCountryCityCommand extends Command
{
    public function __construct(
        private WeatherUtil $weatherUtil,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'Country code')
            ->addArgument('city', InputArgument::REQUIRED, 'City name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if (empty($measurements)) {
            $io->error('Nie znaleziono pomiarów dla podanego kraju i miasta.');
            return Command::FAILURE;
        }

        $location = $measurements[0]->getLocation();

        $io->writeln(sprintf('Location: %s, %s', $location->getCity(), $location->getCountry()));
        $io->table(
            ['Date', 'Temperature', 'Wind', 'Rainfall', 'Pressure'],
            array_map(fn($m) => [
                $m->getDate()->format('Y-m-d'),
                $m->getCelsius(),
                $m->getWind(),
                $m->getRainfall(),
                $m->getPressure(),
            ], $measurements)
        );

        return Command::SUCCESS;
    }
}
