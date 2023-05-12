<?php

namespace App\Traits;

trait RandomNumberGenerator
{
    //this method is use to generate random number
    protected function generateRandomNumber()
    {
        $random = \mt_rand('000000000', '999999999');
        return $random;
    }
}