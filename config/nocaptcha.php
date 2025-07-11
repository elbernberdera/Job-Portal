<?php

return [

    /*
    |--------------------------------------------------------------------------
    | NoCaptcha Site Key
    |--------------------------------------------------------------------------
    |
    | The site key from Google reCAPTCHA admin console.
    |
    */

    'site_key' => env('NOCAPTCHA_SITEKEY', ''),

    /*
    |--------------------------------------------------------------------------
    | NoCaptcha Secret Key
    |--------------------------------------------------------------------------
    |
    | The secret key from Google reCAPTCHA admin console.
    |
    */

    'secret_key' => env('NOCAPTCHA_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | NoCaptcha Options
    |--------------------------------------------------------------------------
    |
    | Additional options for the reCAPTCHA widget.
    |
    */

    'options' => [
        'theme' => 'light',
        'type' => 'image',
        'size' => 'normal',
        'tabindex' => 0,
        'callback' => null,
        'expired_callback' => null,
        'error_callback' => null,
    ],

]; 