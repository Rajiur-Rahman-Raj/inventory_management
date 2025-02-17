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
        '*users-inactive',
        '*users-active',
        'admin/service',
        '*plans-active',
        '*plans-inactive',
        '*sort-payment-methods',
        '*add-fund',
        'success',
        'failed',
        'payment/*',
        '*wish-list',
        '*withdraw-bank-list',
        '*withdraw-bank-from',
        '*update-cart-items*',
        '*get-division-district*',
        '*get-district-upazila*',
        '*get-upazila-union*',
        '*get-selected-sales-center*',
        '*get-year-sales-transaction-chart-records*',
        '*get-year-sales-center-transaction-chart-records*',
    ];
}
