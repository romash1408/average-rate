<?php
namespace Romash1408;

class Currency
{
    static $USD;
    static $EUR;

    public static function init()
    {
        static $initialized = false;

        if ($initialized) 
        {
            return;
        }
        $initialized = true;

        static::$USD = new static("USD", "R01235");
        static::$EUR = new static("EUR", "R01239");
    }

    private $charCode;
    private $cbrId;


    private function __construct($charCode, $cbrId)
    {
        $this->charCode = $charCode;
        $this->cbrId = $cbrId;
    }

    public function getCharCode()
    {
        return $this->charCode;
    }

    public function getCbrId()
    {
        return $this->cbrId;
    }
}

Currency::init();
