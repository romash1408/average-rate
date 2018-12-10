<?php

use PHPUnit\Framework\TestCase;
use Romash1408\AverageRate;
use Romash1408\Currency;

class AverageRateTest extends TestCase
{
    public function testCorrectAnswerForRightDate()
    {
        $a = new AverageRate();
        $date = new DateTime("2007-01-23");
        $this->assertEquals($a->get(Currency::$USD, $date), 26.5214);
        $this->assertEquals($a->get(Currency::$EUR, $date), 34.4009);
    }

    public function testExceptionForIncorrectDate()
    {
        $this->expectException(InvalidArgumentException::class);

        $a = new AverageRate();
        $date = new DateTime("1990-01-01");
        $a->get(Currency::$USD, $date);
    }
}