<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //give admin all products
        if (auth()->user()->role === 'admin') {
            $products = Product::with('category')->paginate(8);

            return view('products.index', ['products' => $products]);
        }

        //only active products for staff
        $products = Product::with('category')
            ->where('status', '=', 'active')
            ->paginate(8);

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        if ($request->user()->cannot('create', $product)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'product_category_id' => 'required|exists:categories,id',
        ]);

        // Map form field to database column
        $validated['category_id'] = $validated['product_category_id'];
        unset($validated['product_category_id']);
        
        $validated['status'] = $validated['status'] ?? 'active';

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'product_category_id' => 'required|exists:categories,id',
        ]);

        // Map form field to database column
        $validated['category_id'] = $validated['product_category_id'];
        unset($validated['product_category_id']);
        
        $validated['status'] = $request->input('status');

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect('/')->with('success', 'Product deleted from the list');
    }
}
