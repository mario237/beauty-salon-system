<?php

use App\Enums\CustomerSource;
use App\Models\Setting;

if (!function_exists('customerSourceBadge')) {
    function customerSourceBadge(string $source): string
    {
        $badgeClasses = [
            CustomerSource::FACEBOOK->value => 'text-light-primary',
            CustomerSource::INSTAGRAM->value => 'text-light-danger',
            CustomerSource::WHATSAPP->value => 'text-light-success',
            CustomerSource::OTHER->value => 'text-light-secondary',
        ];

        return $badgeClasses[$source] ?? 'text-light-secondary';
    }
}

if (!function_exists('getPaymentMethods')) {
    function getPaymentMethods(): array
    {
        return [
            [
                'value' => 'cash',
                'text' => 'Cash',
            ],
            [
                'value' => 'visa',
                'text' => 'Visa',
            ],
            [
                'value' => 'instapay',
                'text' => 'InstaPay',
            ],
        ];
    }
}

if (!function_exists('getSetting')) {
    function getSetting(string $key)
    {
        return Setting::where('key', $key)->first() ?
            Setting::where('key', $key)->first()->value : null;
    }
}
