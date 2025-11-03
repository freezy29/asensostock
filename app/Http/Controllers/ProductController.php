<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'price' => 'required|numeric|min:0.01',
            'critical_level' => 'required|integer|min:0',
        ], [
            'price.min' => 'Price must be greater than 0.',
        ]);

        // Validate that category and unit are active
        $category = \App\Models\Category::find($validated['product_category_id']);
        $unit = \App\Models\Unit::find($validated['product_unit_id']);
        
        if ($category && $category->status !== 'active') {
            return back()->withErrors(['product_category_id' => 'Selected category is not active.'])->withInput();
        }
        
        if ($unit && $unit->status !== 'active') {
            return back()->withErrors(['product_unit_id' => 'Selected unit is not active.'])->withInput();
        }

        // Validate critical_level is not greater than stock_quantity (warning only, but let's validate it makes sense)
        if ($validated['critical_level'] > $validated['stock_quantity']) {
            // This is allowed but will show a warning in the view
        }

        // Map form fields to database columns
        $validated['category_id'] = $validated['product_category_id'];
        $validated['unit_id'] = $validated['product_unit_id'];
        $stockQuantity = $validated['stock_quantity'];
        unset($validated['product_category_id'], $validated['product_unit_id']);

        $validated['status'] = $validated['status'] ?? 'active';

        DB::transaction(function () use ($validated, $stockQuantity) {
            $product = Product::create($validated);

            // If initial stock is provided, create an initial stock-in transaction
            if ($stockQuantity > 0) {
                Transaction::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $stockQuantity,
                    'cost_price' => $validated['price'] * 0.65, // Estimate cost as 65% of price
                    'total_amount' => ($validated['price'] * 0.65) * $stockQuantity,
                    'user_id' => auth()->user()->id,
                ]);
            }
        });

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
        
        // Optimize: Calculate all metrics in a single query using aggregation
        $transactionStats = $product->transactions()
            ->selectRaw('
                SUM(CASE WHEN type = "in" THEN quantity ELSE 0 END) as total_in,
                SUM(CASE WHEN type = "out" THEN quantity ELSE 0 END) as total_out,
                SUM(CASE WHEN type = "in" THEN total_amount ELSE 0 END) as total_cost_value
            ')
            ->first();
        
        return view('products.show', [
            'product' => $product,
            'totalIn' => $transactionStats->total_in ?? 0,
            'totalOut' => $transactionStats->total_out ?? 0,
            'totalCostValue' => $transactionStats->total_cost_value ?? 0,
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
            'price' => 'required|numeric|min:0.01',
            'critical_level' => 'required|integer|min:0',
        ], [
            'price.min' => 'Price must be greater than 0.',
        ]);

        // Validate that category and unit are active
        $category = \App\Models\Category::find($validated['product_category_id']);
        $unit = \App\Models\Unit::find($validated['product_unit_id']);
        
        if ($category && $category->status !== 'active') {
            return back()->withErrors(['product_category_id' => 'Selected category is not active.'])->withInput();
        }
        
        if ($unit && $unit->status !== 'active') {
            return back()->withErrors(['product_unit_id' => 'Selected unit is not active.'])->withInput();
        }

        // Check if stock quantity changed manually
        $oldStock = $product->stock_quantity;
        $newStock = $validated['stock_quantity'];
        $stockDifference = $newStock - $oldStock;

        // Map form fields to database columns
        $validated['category_id'] = $validated['product_category_id'];
        $validated['unit_id'] = $validated['product_unit_id'];
        unset($validated['product_category_id'], $validated['product_unit_id']);
        
        // Handle status - for admins/super_admins it comes from select dropdown
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $validated['status'] = $request->input('status', 'active');
        } else {
            // For staff, keep as active (they can't edit status)
            $validated['status'] = 'active';
        }

        DB::transaction(function () use ($validated, $product, $stockDifference, $oldStock) {
            $product->update($validated);

            // If stock was manually adjusted, create an adjustment transaction
            if ($stockDifference != 0) {
                $adjustmentType = $stockDifference > 0 ? 'in' : 'out';
                $adjustmentQuantity = abs($stockDifference);
                
                // Calculate estimated cost price (use product's current price as reference)
                $estimatedCostPrice = $product->price * 0.65;
                
                Transaction::create([
                    'product_id' => $product->id,
                    'type' => $adjustmentType,
                    'quantity' => $adjustmentQuantity,
                    'cost_price' => $estimatedCostPrice,
                    'total_amount' => $estimatedCostPrice * $adjustmentQuantity,
                    'user_id' => auth()->user()->id,
                ]);
            }
        });

        $message = 'Product updated successfully!';
        if ($stockDifference != 0) {
            $message .= ' Stock adjustment transaction has been created.';
        }

        return redirect()->route('products.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Check if product has transactions
        $transactionsCount = $product->transactions()->count();
        
        if ($transactionsCount > 0) {
            return redirect()->route('products.index')
                ->with('error', "Cannot delete this product. It has {$transactionsCount} transaction(s) associated with it. Consider deactivating it instead.");
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
