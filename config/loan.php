<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Loan Interest Rate (% per month)
    |--------------------------------------------------------------------------
    | This rate is set by admin only. Customers cannot change it.
    */
    'default_interest_rate' => env('LOAN_DEFAULT_INTEREST_RATE', 2.0),
];
