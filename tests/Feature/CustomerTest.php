<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
});

test('can display customer list page', function () {
    Customer::factory()->count(15)->create();

    $response = $this->get(route('customers.index'));

    $response->assertStatus(200);
    $response->assertViewHas('customers');
    $response->assertViewHas('totalCustomers', 15);
});

test('can display customer create page', function () {
    $response = $this->get(route('customers.create'));

    $response->assertStatus(200);
});

test('can store a new customer with valid data', function () {
    $customerData = [
        'customer_code' => 'CUST-9999',
        'first_name' => 'Sok',
        'last_name' => 'Dara',
        'gender' => 'Male',
        'date_of_birth' => '1995-05-15',
        'phone' => '012345678',
        'email' => 'sok.dara@example.com',
        'address' => 'Phnom Penh',
        'city' => 'Phnom Penh',
        'status' => 'Active',
    ];

    $response = $this->post(route('customers.store'), $customerData);

    $response->assertRedirect(route('customers.index'));
    $this->assertDatabaseHas('customers', [
        'customer_code' => 'CUST-9999',
        'email' => 'sok.dara@example.com',
    ]);
});

test('validates customer creation inputs', function () {
    $response = $this->post(route('customers.store'), []);

    $response->assertSessionHasErrors(['customer_code', 'first_name', 'last_name', 'gender', 'phone', 'email', 'status']);
});

test('can view customer details', function () {
    $customer = Customer::factory()->create();

    $response = $this->get(route('customers.show', $customer->id));

    $response->assertStatus(200);
    $response->assertSee($customer->customer_code);
    $response->assertSee($customer->first_name);
});

test('can edit and update a customer', function () {
    $customer = Customer::factory()->create(['status' => 'Active']);

    $response = $this->put(route('customers.update', $customer->id), [
        'customer_code' => $customer->customer_code,
        'first_name' => 'UpdatedName',
        'last_name' => $customer->last_name,
        'gender' => $customer->gender,
        'phone' => $customer->phone,
        'email' => $customer->email,
        'status' => 'Inactive',
    ]);

    $response->assertRedirect(route('customers.index'));
    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'first_name' => 'UpdatedName',
        'status' => 'Inactive',
    ]);
});

test('can delete a customer', function () {
    $customer = Customer::factory()->create();

    $response = $this->delete(route('customers.destroy', $customer->id));

    $response->assertRedirect(route('customers.index'));
    $this->assertDatabaseMissing('customers', [
        'id' => $customer->id,
    ]);
});

test('can search customers by name and filter by status', function () {
    Customer::factory()->create(['first_name' => 'UniqueSearchName', 'status' => 'Active']);
    Customer::factory()->create(['first_name' => 'OtherName', 'status' => 'Inactive']);

    $response = $this->get(route('customers.index', ['name' => 'UniqueSearchName', 'status' => 'Active']));

    $response->assertStatus(200);
    $response->assertSee('UniqueSearchName');
    $response->assertDontSee('OtherName');
});
