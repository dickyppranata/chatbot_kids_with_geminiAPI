<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Gemini API Configuration
    |--------------------------------------------------------------------------
    |
    | API Key, Base Endpoint, Default Model, and Fallback Candidates.
    | Dapatkan API Key gratis di: https://aistudio.google.com/app/apikey
    |
    */

    'api_key' => env('GEMINI_API_KEY'),

    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),

    /*
    | Model Utama: Gemini 3.1 Flash Lite dipilih karena memiliki kuota
    | paling besar (500 RPD / 15 RPM).
    */
    'default_model' => env('GEMINI_DEFAULT_MODEL', 'gemini-3.1-flash-lite'),

    /*
    |--------------------------------------------------------------------------
    | Model Candidates untuk Looping / Fallback Otomatis
    |--------------------------------------------------------------------------
    |
    | Diurutkan berdasarkan batas kuota (RPM & RPD) yang aktif pada akun:
    | 1. gemini-3.1-flash-lite (15 RPM | 500 RPD) -> Utama
    | 2. gemini-2.5-flash-lite (10 RPM | 20 RPD)  -> Fallback 1
    | 3. gemini-3.5-flash      (5 RPM  | 20 RPD)  -> Fallback 2
    | 4. gemini-3-flash        (5 RPM  | 20 RPD)  -> Fallback 3
    | 5. gemini-2.5-flash      (5 RPM  | 20 RPD)  -> Fallback 4
    |
    */
    'fallback_models' => [
        'gemini-3.1-flash-lite',
        'gemini-2.5-flash-lite',
        'gemini-3.5-flash',
        'gemini-3-flash',
        'gemini-2.5-flash',
    ],

    /*
    |--------------------------------------------------------------------------
    | Safety Guardrails Settings (Keamanan Anak-Anak)
    |--------------------------------------------------------------------------
    |
    | Menyaring konten berbahaya, ujaran kebencian, pelecehan, dan seksual.
    |
    */
    'safety_settings' => [
        [
            'category'  => 'HARM_CATEGORY_HARASSMENT',
            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
        ],
        [
            'category'  => 'HARM_CATEGORY_HATE_SPEECH',
            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
        ],
        [
            'category'  => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
            'threshold' => 'BLOCK_LOW_AND_ABOVE',
        ],
        [
            'category'  => 'HARM_CATEGORY_DANGEROUS_CONTENT',
            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Parameter Generasi Default
    |--------------------------------------------------------------------------
    */
    'generation_config' => [
        'temperature'       => 0.7,
        'top_p'             => 0.9,
        'top_k'             => 40,
        'maxOutputTokens'   => 1024,
    ],

];