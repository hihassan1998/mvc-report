<?php

namespace App\Tests\Entity;

use App\Entity\EmissionsData;
use PHPUnit\Framework\TestCase;

/**
 * Class EmissionsDataTest
 *
 * Tests for the EmissionsData entity properties.
 */

class EmissionsDataTest extends TestCase
{
    /**
     * Test setting and getting properties of EmissionsData.
     *
     * @return void
     */
    public function testEmissionsDataProperties(): void
    {
        $emissions = new EmissionsData();

        $year = 2020;
        $emissionsSweden = 36.5;
        $emissionsAbroad = 65.2;
        $total = 101.7;

        $emissions->setYear($year);
        $emissions->setEmissionsSweden($emissionsSweden);
        $emissions->setEmissionsAbroad($emissionsAbroad);
        $emissions->setTotal($total);

        $this->assertSame($year, $emissions->getYear());
        $this->assertSame($emissionsSweden, $emissions->getEmissionsSweden());
        $this->assertSame($emissionsAbroad, $emissions->getEmissionsAbroad());
        $this->assertSame($total, $emissions->getTotal());

        $this->assertNull($emissions->getId());
    }
}
