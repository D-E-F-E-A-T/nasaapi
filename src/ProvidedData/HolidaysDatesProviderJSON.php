<?php

declare(strict_types=1);

namespace App\ProvidedData;

class HolidaysDatesProviderJSON implements HolidaysDatesProviderInterface
{
    private HolidaysDatesCollection $holidaysDatesCollection;
    private string $holidaysDatesFilePath;

    public function __construct($holidaysDatesFilePath)
    {
        $this->holidaysDatesFilePath = $holidaysDatesFilePath;
        $this->holidaysDatesCollection = new HolidaysDatesCollection();
    }

    public function getHolidaysDates(): HolidaysDatesCollection
    {
        $dates = json_decode(file_get_contents($this->holidaysDatesFilePath), true);
        foreach ($dates as $date) {
            $this->holidaysDatesCollection->add(new \DateTime($date));
        }

        return $this->holidaysDatesCollection;
    }

}