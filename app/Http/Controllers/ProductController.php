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
    public function index(Request $request)
    {
        //give admin and super_admin all products
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $query = Product::with(['category', 'unit']);
        } else {
            //only active products for staff
            $query = Product::with(['category', 'unit'])
                ->where('status', '=', 'active');
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply status filter
        if ($request->filled('status')) {
            // For staff, only allow filtering by active status (they can't see inactive products)
            if (auth()->user()->role === 'staff' && $request->status !== 'active') {
                // Staff filtering by non-active status is not allowed, default to active
                $query->where('status', 'active');
            } else {
                $query->where('status', $request->status);
            }
        }

        // Apply stock status filter
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'critical') {
                $query->whereRaw('stock_quantity <= critical_level');
            } elseif ($request->stock_status === 'low') {
                $query->whereRaw('stock_quantity > critical_level AND stock_quantity <= (critical_level * 1.5)');
            } elseif ($request->stock_status === 'ok') {
                $query->whereRaw('stock_quantity > (critical_level * 1.5)');
            }
        }

        $products = $query->paginate(8)->withQueryString();

        // Get categories for filter dropdown
        $categories = \App\Models\Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
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
            'product_unit_id' => 'required|exists:units,id',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'critical_level' => 'required|integer|min:0',
        ]);

        // Map form fields to database columns
        $validated['category_id'] = $validated['product_category_id'];
        $validated['unit_id'] = $validated['product_unit_id'];
        unset($validated['product_category_id'], $validated['product_unit_id']);
        
        $validated['status'] = $validated['status'] ?? 'active';

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'unit', 'transactions' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);
        
        // Calculate additional metrics
        $totalIn = $product->transactions()->where('type', 'in')->sum('quantity');
        $totalOut = $product->transactions()->where('type', 'out')->sum('quantity');
        $totalCostValue = $product->transactions()->where('type', 'in')->sum('total_amount');
        
        return view('products.show', [
            'product' => $product,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'totalCostValue' => $totalCostValue,
        ]);
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
            'product_unit_id' => 'required|exists:units,id',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'critical_level' => 'required|integer|min:0',
        ]);

        // Map form fields to database columns
        $validated['category_id'] = $validated['product_category_id'];
        $validated['unit_id'] = $validated['product_unit_id'];
        unset($validated['product_category_id'], $validated['product_unit_id']);
        
        // Handle status checkbox (if checked = active, unchecked = inactive)
        $validated['status'] = $request->input('status') ? 'active' : 'inactive';

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
