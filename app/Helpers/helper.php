<?php

use App\Enums\CustomerSource;

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
