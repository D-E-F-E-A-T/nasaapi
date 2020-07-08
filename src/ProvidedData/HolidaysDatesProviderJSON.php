<?php

declare(strict_types=1);

namespace App\ProvidedData;

class HolidaysDatesProviderJSON implements HolidaysDatesProviderInterface
{
    private HolidaysDatesCollection $holidaysDatesCollection;
    private string $holidaysDatesFilePath;
    const FILE_NOT_FOUND = 'File not found. Please check HOLIDAYS_DATES_FILE_PATH parameter in your .env file.';
    const EXPECT_JSON_STRUCTURE = 'Expected JSON structure.';


    public function __construct($holidaysDatesFilePath)
    {
        $this->holidaysDatesFilePath = $holidaysDatesFilePath;
        $this->holidaysDatesCollection = new HolidaysDatesCollection();
    }

    public function getHolidaysDates(): HolidaysDatesCollection
    {
        if (!file_exists($this->holidaysDatesFilePath)) {
            throw new \Exception(self::FILE_NOT_FOUND);
        }

        $dates = json_decode(file_get_contents($this->holidaysDatesFilePath), true);
        if (null === $dates) {
            throw new \Exception(self::EXPECT_JSON_STRUCTURE);
        }
        foreach ($dates as $date) {
            $this->holidaysDatesCollection->add(new \DateTime($date));
        }

        return $this->holidaysDatesCollection;
    }

}