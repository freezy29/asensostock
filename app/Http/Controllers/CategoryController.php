<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $query = Category::withCount('products');
        } else {
            //only active categories for staff
            $query = Category::where('status', '=', 'active')
                ->withCount('products');
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Apply status filter
        if ($request->filled('status')) {
            // For staff, only allow filtering by active status
            if (auth()->user()->role === 'staff' && $request->status !== 'active') {
                $query->where('status', 'active');
            } else {
                $query->where('status', $request->status);
            }
        }

        $categories = $query->orderBy('name')->paginate(8)->withQueryString();

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        if ($request->user()->cannot('create', $category)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Handle status - for admins/super_admins it comes from select dropdown
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $validated['status'] = $request->input('status', 'active');
        } else {
            // For staff, keep as active (they can't edit status)
            $validated['status'] = 'active';
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Count all products (for display), but filter when loading
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $category->loadCount('products');
            $products = $category->products()
                ->with(['unit'])
                ->orderBy('name')
                ->paginate(10);
        } else {
            // Staff can only see active products
            $category->loadCount(['products' => function($query) {
                $query->where('status', 'active');
            }]);
            $products = $category->products()
                ->where('status', 'active')
                ->with(['unit'])
                ->orderBy('name')
                ->paginate(10);
        }
        
        return view('categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($request->user()->cannot('update', $category)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Handle status - for admins/super_admins it comes from select dropdown
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $validated['status'] = $request->input('status', 'active');
        } else {
            // For staff, keep current status (they can't edit status)
            $validated['status'] = $category->status;
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        // Check for active products using this category (soft delete check)
        $activeProductsCount = $category->products()->whereNull('deleted_at')->count();
        if ($activeProductsCount > 0) {
            return redirect()->route('categories.index')
                ->with('error', "Cannot delete this category. It is currently being used by {$activeProductsCount} active product(s). Please change those products to use a different category first.");
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted from the list!');
    }
}
