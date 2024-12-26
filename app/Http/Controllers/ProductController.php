<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::mostRecent()
            ->with('category')
            ->with('user')
            ->simplePaginate(6);
        $categories = ProductCategory::all();

        return inertia('Product/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', Listing::class);
        return inertia('Product/Create');
    }

    public function store(StoreProductRequest $request)
    {
        // Les données sont déjà validées à ce stade
        $validated = $request->validated();

        // Associer l'utilisateur actuel en tant que créateur du produit
        $product = $request->user()->products()->create($validated);

        return redirect()->back()->with('success', 'Produit créé avec succès.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
