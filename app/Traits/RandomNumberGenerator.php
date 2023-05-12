<?php

namespace App\Traits;

use App\AppUser;
use App\ProviderCount;
use App\Setting;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

trait RandomNumberGenerator
{
    //this method is use to generate random number
    protected function generateRandomNumber()
    {
        $random = \mt_rand('000000000', '999999999');
        return $random;
    }
}