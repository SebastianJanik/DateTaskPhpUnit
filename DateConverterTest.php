<?php

require_once 'DateConverter.php';

use PHPUnit\Framework\TestCase;

class DateConverterTest extends TestCase
{
    public function test_short_year_invalid()
    {
        $date = new DateConverter('13/13/13');
        $this->assertEquals($date->getInvalidDateMessage(), $date->getEarliestDate());
    }

    public function test_full_year_invalid()
    {
        $date = new DateConverter('15/13/2213');
        $this->assertEquals($date->getInvalidDateMessage(), $date->getEarliestDate());
    }

    public function test_short_year_valid()
    {
        $date = new DateConverter('12/12/12');
        $this->assertEquals('2012-12-12', $date->getEarliestDate());
    }

    public function test_short2_year_valid()
    {
        $date = new DateConverter('12/12/2');
        $this->assertEquals('2002-12-12', $date->getEarliestDate());
    }

    public function test_full_year_valid()
    {
        $date = new DateConverter('05/11/2005');
        $this->assertEquals('2005-05-11', $date->getEarliestDate());
    }

    public function test_one_digits_valid()
    {
        $date = new DateConverter('2/3/4');
        $this->assertEquals('2002-03-04', $date->getEarliestDate());
    }

    public function test_three_digits_year_valid()
    {
        $date = new DateConverter('2/3/444');
        $this->assertEquals('2444-02-03', $date->getEarliestDate());
    }

    public function test_three_digits_year_invalid()
    {
        $date = new DateConverter('32/13/444');
        $this->assertEquals($date->getInvalidDateMessage(), $date->getEarliestDate());
    }

    public function test_leap_full_year_invalid()
    {
        $date = new DateConverter('2100/29/02');
        $this->assertEquals($date->getInvalidDateMessage(), $date->getEarliestDate());
    }

    public function test_leap_short_year_invalid()
    {
        $date = new DateConverter('39/29/02');
        $this->assertEquals($date->getInvalidDateMessage(), $date->getEarliestDate());
    }

    public function test_leap_short_year_correct()
    {
        $date = new DateConverter('16/02/29');
        $this->assertEquals("2016-02-29", $date->getEarliestDate());
    }

    public function test_leap_full_year_correct()
    {
        $date = new DateConverter('02/2116/29');
        $this->assertEquals("2116-02-29", $date->getEarliestDate());
    }
}