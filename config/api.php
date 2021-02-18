<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authorization token for internal API
    |--------------------------------------------------------------------------
    |
    */

    'auth_token' => env('API_AUTH_TOKEN'),
    'base_uri' =>  env('API_BASE_URI', 'http://127.0.0.1:8000/'),

];
