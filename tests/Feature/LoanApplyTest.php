<?php

use App\Models\Loan;
use App\Models\User;

test('customer can apply for a loan and is redirected to my loans', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($customer)->post(route('loans.apply.store'), [
        'principal_amount' => 1000,
        'term_months' => 12,
    ]);

    $response->assertRedirect(route('loans.my_loans'));
    $response->assertSessionHas('success');
});

test('customer cannot set interest rate — it uses the admin default', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $this->actingAs($customer)->post(route('loans.apply.store'), [
        'principal_amount' => 500,
        'term_months' => 6,
        'interest_rate' => 99, // attempt to override
    ]);

    $loan = Loan::where('customer_id', $customer->id)->latest()->first();

    expect((float) $loan->interest_rate)->toBe((float) config('loan.default_interest_rate'));
});
