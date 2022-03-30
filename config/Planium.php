<?php

class Planium
{
    public $plans = array();
    public $prices = array();

    public function __construct()
    {
        //decode plans and prices from plans.json and prices.json
        $this->plans = json_decode(file_get_contents(__DIR__ . '/plans.json'), true);
        $this->prices = json_decode(file_get_contents(__DIR__ . '/prices.json'), true);
    }

}

