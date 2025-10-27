<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $categories = ProductCategory::all();
            return view('product_categories.index', ['categories' => $categories]);
        }

        //only active products for staff
        $categories = ProductCategory::where('status', '=', 'active')
            ->get();

        return view('product_categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProductCategory $category)
    {
        if ($request->user()->cannot('create', $category)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $validated['status'] = $validated['status'] ?? 'active';

        ProductCategory::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $category)
    {
        return view('product_categories.show', ['Category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        $this->authorize('update', $category);

        return view('product_categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        if ($request->user()->cannot('update', $category)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $validated['status'] = $request->input('status');

        $category->update($validated);

        return redirect()->route('product_categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('product_categories.index')->with('success', 'Category deleted from the list!');
    }
}
