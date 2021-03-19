<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
        'http://127.0.0.1/gold_project/new_gold_api/public/api/login',
        'http://127.0.0.1/gold_project/new_gold_api/public/api/*'

    ];
}
