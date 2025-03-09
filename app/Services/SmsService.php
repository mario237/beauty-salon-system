<?php

namespace App\Services;

use App\Facades\OTP;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SmsService
{

    /**
     * @throws ConnectionException
     */
    private static function sendSMS(
        string $countryCode,
        string $mobile,
        string $message
    ): bool
    {
        $body = [
            "environment" => getSetting('sms_environment') ?? config('smsmisr.environment'),
            "username" =>getSetting('sms_username') ?? config('smsmisr.username'),
            "password" =>getSetting('sms_password') ?? config('smsmisr.password'),
            "sender" =>getSetting('sms_sender') ?? config('smsmisr.sender'),
            "mobile" => str_replace("+", "", $countryCode . $mobile),
            "language" =>getSetting('sms_language') ?? config('smsmisr.language'),
            "message" => $message
        ];

        $response = Http::post(getSetting('endpoint') ?? config('smsmisr.endpoint'), $body);

        return $response->status() === 200 && $response->successful() && $response->json()['Code'] === '1901';
    }
}
