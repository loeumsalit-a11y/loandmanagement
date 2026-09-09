<?php

use App\Models\User;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('customer is forbidden from disbursing a loan', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $loan = Loan::create([
        'customer_id' => $customer->id,
        'principal_amount' => 1000.00,
        'interest_rate' => 2.00,
        'term_months' => 6,
        'status' => 'Approved',
    ]);

    $response = $this->actingAs($customer)
        ->post(route('loans.disburse', $loan));

    $response->assertStatus(403);
});

test('admin can disburse an approved loan', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $admin = User::factory()->create(['role' => 'admin']);
    $loan = Loan::create([
        'customer_id' => $customer->id,
        'principal_amount' => 1000.00,
        'interest_rate' => 2.00,
        'term_months' => 6,
        'status' => 'Approved',
    ]);

    $response = $this->actingAs($admin)
        ->post(route('loans.disburse', $loan));

    $response->assertRedirect(route('loans.schedule', $loan));
    $this->assertDatabaseHas('loans', [
        'id' => $loan->id,
        'status' => 'Disbursed',
    ]);
});
