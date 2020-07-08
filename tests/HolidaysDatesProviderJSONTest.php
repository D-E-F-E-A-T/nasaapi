<?php

declare(strict_types=1);

namespace App\Tests;

use App\ProvidedData\HolidaysDatesCollection;
use App\ProvidedData\HolidaysDatesProviderJSON;
use PHPUnit\Framework\TestCase;

final class HolidaysDatesProviderJSONTest extends TestCase
{
    public function testBadPathToJsonFile()
    {
        $provider = new HolidaysDatesProviderJSON('/bad/path');
        $this->expectExceptionMessage($provider::FILE_NOT_FOUND);
        $provider->getHolidaysDates();
    }

    public function testGetHolidaysDates()
    {
        $providerJSON = new HolidaysDatesProviderJSON('src/ProvidedData/PolishHolidays2019.json');
        $this->assertInstanceOf(HolidaysDatesCollection::class, $providerJSON->getHolidaysDates());
    }
}