<?php

return [
    /*
     * SMSMISR_ENDPOINT
     */
    'endpoint' => env('SMSMISR_ENDPOINT', 'https://smsmisr.com/api/'),
    /*
     * SMSMISR_ENVIRONMENT
     */
    'environment' => env('SMSMISR_ENVIRONMENT', '2'),

    /*
     * SMSMISR_USERNAME
     */
    'username' => env('SMSMISR_USERNAME'),

    /*
     * SMSMISR_PASSWORD
     */
    'password' => env('SMSMISR_PASSWORD'),

    /*
     * SMSMISR_FROM
     */
    'sender' => env('SMSMISR_SENDER'),

    /*
     * SMSMISR_LANGUAGE
     */
    'language' => env('SMSMISR_LANGUAGE'),
];
