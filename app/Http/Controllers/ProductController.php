<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::mostRecent()
            ->with('category')
            ->with('user')
            ->simplePaginate(8);
        $categories = ProductCategory::all();

        return inertia('Product/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function store(ProductRequest $request)
    {
        // Valider les données
        $validated = $request->validated();

        // Vérifier et gérer le fichier téléversé (cover_photo)
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('products', 'public');
            $validated['filename'] = $filePath;
        }
        // Créer le produit avec les données validées et l'utilisateur associé
        $product = $request->user()->products()->create($validated);

        $product->filename = $filePath;
        $product->save();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Produit créé avec succès.');
    }

    public function update(ProductRequest $request, Product $product)
    {
        // Valider les données
        $validated = $request->validated();

        // Vérifier et gérer le fichier téléversé (image)
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('products', 'public');
            $validated['filename'] = $filePath;
        }

        // Mettre à jour le produit avec les données validées
        $product->update($validated);

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
