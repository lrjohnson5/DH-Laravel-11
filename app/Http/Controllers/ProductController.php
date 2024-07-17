<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\SaveProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => Product::orderBy('created_at')->paginate(3)
        ]);
    }

    // Displays form for entering product data
    public function create()
    {
        return view('products.create');
    }

    public function store(SaveProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()->route('products.show', $product)
            ->with('status', 'Product created successfully.');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', [
            'product' => $product   // can be replaced using the compact() function: compact('product')
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(SaveProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.show', $product)
            ->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('status', 'Product deleted successfully');
    }
}
