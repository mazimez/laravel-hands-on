<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;

trait SmsManager
{
    /**
     * send OTP to user
     *
     * @param string $phone_number - phone number on which the OTP should be sent
     * @param string $otp - the OTP that's going to be sent to given phone number
     * @return boolean
     * @throws Throwable
     */
    static function sendTwoFactorMessage($phone_number, $otp)
    {
        //TODO::make this country code dynamic, not static '+91'
        $phone_number = '+91' . $phone_number;
        try {
            $response = Http::get(config('services.two_factor.api_url') . config('services.two_factor.api_key') . '/SMS/' . $phone_number . '/' . $otp . '/' . config('services.two_factor.template_name'));
            if ($response->object()->Status != "Success") {
                throw new Exception($response->object()->Details);
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }
        return true;
    }
}