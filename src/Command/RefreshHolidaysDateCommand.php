<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\HolidaysDates;
use App\ProvidedData\HolidaysDatesProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RefreshHolidaysDateCommand extends Command
{
    protected static $defaultName = 'nasa-mars-api:refresh-holidays';
    private HolidaysDatesProviderInterface $holidaysDatesProvider;
    private EntityManagerInterface $holidaysDatesManager;

    public function __construct(HolidaysDatesProviderInterface $provider, EntityManagerInterface $holidaysDatesManager)
    {
        $this->holidaysDatesProvider = $provider;
        $this->holidaysDatesManager = $holidaysDatesManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->holidaysDatesManager->getRepository(HolidaysDates::class)->clearTable();

        foreach ($this->holidaysDatesProvider->getHolidaysDates() as $holidayDate) {
            $this->holidaysDatesManager->persist((new HolidaysDates())->setDate($holidayDate));
        }

        $this->holidaysDatesManager->flush();

        return 0;
    }
}