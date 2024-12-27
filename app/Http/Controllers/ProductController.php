<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utils\FileHandler;
use App\Models\ProductCategory;
use App\Http\Requests\ProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of products with pagination and categories.
     */
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::mostRecent()
                ->with(['category', 'user'])
                ->simplePaginate(4),
            'categories' => ProductCategory::all(),
        ]);
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $validated['filename'] = FileHandler::handleImageUpload($request, 'filename', 'products/product.jpg');

        $product = $request->user()->products()->create($validated);

        $product->filename = $validated['filename'];
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Update the specified product in the database.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();
        $validated['filename'] = FileHandler::handleImageUpload($request, 'filename', 'products/product.jpg', $product->filename);
        $product->filename = $validated['filename'];
        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from the database.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        FileHandler::deleteFile($product->filename, 'products/product.jpg');
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
