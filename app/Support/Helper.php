<?php
namespace App\Support;

use Illuminate\Support\Arr;

class Helper
{
    public static function generateOtp(int $length = 6)
    {
        $otp = implode("", Arr::random(range(0, 9), $length));
        return $otp;
    }
}