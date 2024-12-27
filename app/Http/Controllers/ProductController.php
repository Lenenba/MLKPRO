<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
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
                ->simplePaginate(8),
            'categories' => ProductCategory::all(),
        ]);
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $validated['filename'] = $this->handleImageUpload($request);

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
        $validated['filename'] = $this->handleImageUpload($request, $product->filename);

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

        $this->deleteFile($product->filename);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Handle image upload or assign default image if none provided.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $oldFilename
     * @return string
     */
    private function handleImageUpload($request, ?string $oldFilename = null): string
    {
        if ($request->hasFile('image')) {
            // Delete old file if uploading a new one
            $this->deleteFile($oldFilename);
            return $request->file('image')->store('products', 'public');
        }

        // Return existing filename or default image
        return $oldFilename ?? 'products/product.jpg';
    }

    /**
     * Delete a file if it exists, but do not delete the default image.
     *
     * @param string|null $filePath
     * @return void
     */
    private function deleteFile(?string $filePath): void
    {
        // Define the default image path as a constant or use a configuration
        $defaultImagePath = 'products/product.jpg';

        if ($filePath && $filePath !== $defaultImagePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
