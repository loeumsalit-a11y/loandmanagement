<?php

use App\Models\Loan;
use App\Models\User;
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

test('loan officer can disburse an approved loan', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $officer = User::factory()->create(['role' => 'loan_officer']);
    $loan = Loan::create([
        'customer_id' => $customer->id,
        'principal_amount' => 1000.00,
        'interest_rate' => 2.00,
        'term_months' => 6,
        'status' => 'Approved',
    ]);

    $response = $this->actingAs($officer)
        ->post(route('loans.disburse', $loan));

    $response->assertRedirect(route('loans.schedule', $loan));
    $this->assertDatabaseHas('loans', [
        'id' => $loan->id,
        'status' => 'Disbursed',
    ]);
});

test('loan officer can access loan settings', function () {
    $officer = User::factory()->create(['role' => 'loan_officer']);

    $response = $this->actingAs($officer)
        ->get(route('loans.settings.edit'));

    $response->assertOk();
});

test('cashier cannot access loan settings', function () {
    $cashier = User::factory()->create(['role' => 'cashier']);

    $response = $this->actingAs($cashier)
        ->get(route('loans.settings.edit'));

    $response->assertStatus(403);
});
