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
        if (file_exists($this->holidaysDatesFilePath)) {
            $dates = json_decode(file_get_contents($this->holidaysDatesFilePath), true);
            if (null === $dates) {
                throw new \Exception('Invalid provided JSON file.');
            }
            foreach ($dates as $date) {
                $this->holidaysDatesCollection->add(new \DateTime($date));
            }
        } else {
            throw new \Exception('File not found. Please check HOLIDAYS_DATES_FILE_PATH parameter in your .env file.');
        }

        return $this->holidaysDatesCollection;
    }

}