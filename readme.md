# Average Rate

## Description
Test task for Movavi.

Class `AverageRate` gets exchange rate for EUR or USD on porposed date
from https://www.cbr.ru and https://cash.rbc.ru and returns its average value

## Install
Via Composer

``` bash
$ composer require romash1408/average-rate
```

## Example

``` php
require "vendor/autoload.php";

use Romash1408\AverageRate;
use Romash1408\Currency;

$averageRate = new AverageRate();
$date = new DateTime("2007-01-23");
echo $average->get(Currency::$USD, $date); // 26.5214
```
