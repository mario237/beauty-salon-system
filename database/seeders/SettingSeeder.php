<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'sms_endpoint', 'value' => config('smsmisr.endpoint')],
            ['key' => 'sms_environment', 'value' => config('smsmisr.environment')],
            ['key' => 'sms_username', 'value' => config('smsmisr.username')],
            ['key' => 'sms_password', 'value' => config('smsmisr.password')],
            ['key' => 'sms_sender', 'value' => config('smsmisr.sender')],
            ['key' => 'sms_language', 'value' => config('smsmisr.language')],
        ];
        foreach ($settings as $setting) {
            Setting::updateOrCreate([
                'key' => $setting['key'],
            ], $setting);
        }
    }
}
