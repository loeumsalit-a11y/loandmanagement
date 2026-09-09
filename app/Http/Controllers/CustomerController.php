<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // 12. Search by first_name or last_name
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('first_name', 'like', '%'.$name.'%')
                    ->orWhere('last_name', 'like', '%'.$name.'%');
            });
        }

        // 13. Search by Phone Number
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%'.$request->input('phone').'%');
        }

        // 11. Filter by Status (Active/Inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 14. Filter by City
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // 15 & 16. Sorting (Name A-Z, Newest created_at, Oldest created_at, Code)
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'name_asc' => $query->orderBy('first_name', 'asc')->orderBy('last_name', 'asc'),
            'name_desc' => $query->orderBy('first_name', 'desc')->orderBy('last_name', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'), // 16. Newest created
        };

        // 17. Pagination (10 per page)
        $customers = $query->paginate(10)->withQueryString();

        // 18. Aggregate: Count total customers
        $totalCustomers = Customer::count();

        // 19. Aggregate: Count active status customers
        $totalActiveCustomers = Customer::where('status', 'Active')->count();

        // 20. Aggregate: Count customers per city
        $customersByCity = Customer::select('city', DB::raw('count(*) as total'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Available distinct cities for dropdown filter
        $citiesList = Customer::whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city');

        return view('customers.index', compact(
            'customers',
            'totalCustomers',
            'totalActiveCustomers',
            'customersByCity',
            'citiesList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 10. Validation
        $validated = $request->validate([
            'customer_code' => ['required', 'string', 'max:20', 'unique:customers,customer_code'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        // 5. Store using Eloquent
        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'រក្សាទុកព័ត៌មានអតិថិជនបានជោគជ័យ!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 6. Show detailed customer info
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 7. Edit form
        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        // 10. Validation
        $validated = $request->validate([
            'customer_code' => ['required', 'string', 'max:20', Rule::unique('customers', 'customer_code')->ignore($customer->id)],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        // 8. Update using Eloquent Update
        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'កែប្រែព័ត៌មានអតិថិជនបានជោគជ័យ!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 9. Delete customer from Database
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'លុបទិន្នន័យអតិថិជនបានជោគជ័យ!');
    }
}
