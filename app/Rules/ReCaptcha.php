<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('nocaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        \Log::info('reCAPTCHA response', ['response' => $response->json()]);

        if (!$response->json('success')) {
            $fail('The reCAPTCHA verification failed. Please try again.');
        }
    }
} 