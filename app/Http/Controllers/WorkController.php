<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Work;
use App\Models\ProductWork;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class WorkController extends Controller
{
    /**
     * Display a listing of the works.
     */
    public function index(Request $request)
    {
        $works = Work::with(['customer', 'products', 'ratings'])
            ->orderBy('work_date', 'desc')
            ->paginate(10);

        return inertia('Work/Index', ['works' => $works]);
    }

    /**
     * Show the form for creating a new work.
     */
    public function create(Int $customerId = null)
    {
        $customer = Customer::with('works')->findOrFail($customerId);
        return inertia('Work/Create', ['customer' => $customer]);
    }

    /**
     * Store a newly created work in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required|string',
            'work_date' => 'required|date',
            'time_spent' => 'nullable|integer|min:0',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'products' => 'array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity_used' => 'required_with:products|integer|min:1',
        ]);

        $work = Work::create($validated);

        // Attach products if provided
        if ($request->has('products')) {
            foreach ($validated['products'] as $product) {
                ProductWork::create([
                    'work_id' => $work->id,
                    'product_id' => $product['product_id'],
                    'quantity_used' => $product['quantity_used'],
                ]);
            }
        }

        return response()->json(['message' => 'Work created successfully', 'work' => $work], 201);
    }

    /**
     * Display the specified work.
     */
    public function show($id)
    {
        $work = Work::with(['customer', 'products', 'ratings'])->findOrFail($id);

        return inertia('Work/Index', ['work' => $work]);
    }

    /**
     * Update the specified work in storage.
     */
    public function update(Request $request, $id)
    {
        $work = Work::findOrFail($id);

        $validated = $request->validate([
            'description' => 'nullable|string',
            'work_date' => 'nullable|date',
            'time_spent' => 'nullable|integer|min:0',
            'is_completed' => 'nullable|boolean',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'products' => 'array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity_used' => 'required_with:products|integer|min:1',
        ]);

        $work->update($validated);

        // Update products if provided
        if ($request->has('products')) {
            ProductWork::where('work_id', $work->id)->delete();

            foreach ($validated['products'] as $product) {
                ProductWork::create([
                    'work_id' => $work->id,
                    'product_id' => $product['product_id'],
                    'quantity_used' => $product['quantity_used'],
                ]);
            }
        }

        return response()->json(['message' => 'Work updated successfully', 'work' => $work]);
    }

    /**
     * Remove the specified work from storage.
     */
    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        return response()->json(['message' => 'Work deleted successfully']);
    }
}
