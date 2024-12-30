<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductWorkController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'work_id' => 'required|exists:works,id',
            'quantity_used' => 'required|integer|min:1',
            'unit' => 'required|string',
        ]);

        $work = Work::with(['customer', 'products', 'ratings'])->findOrFail($validated['work_id']);
        $work->products()->attach($validated['product_id'], [
            'quantity_used' => $validated['quantity_used'],
            'unit' => $validated['unit'],
        ]);


        $filters = $request->only([
            'category_id',
            'name',
            'stock'
        ]);
        $products = Product::mostRecent()
        ->filter($filters)
        ->with(['category'])
        ->simplePaginate(4)
        ->withQueryString();
        $categories = ProductCategory::all();
        $customer = $work->customer->load('works');

        return redirect()->route('work.edit',  [
            'work_id' => $work->id,
            'work' => $work,
            'customer' => $customer
        ])->with('success', 'product added successfully.');
    }
}
