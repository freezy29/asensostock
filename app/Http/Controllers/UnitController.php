<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $query = Unit::withCount('products');
        } else {
            //only active units for staff
            $query = Unit::where('status', '=', 'active')
                ->withCount('products');
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('abbreviation', 'like', "%{$search}%");
            });
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

        $units = $query->orderBy('name')->paginate(8)->withQueryString();

        return view('units.index', ['units' => $units]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Unit::class);

        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Unit::class);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'abbreviation' => 'required|max:10|unique:units,abbreviation|regex:/^[a-z0-9]+$/',
        ], [
            'abbreviation.required' => 'The abbreviation field is required.',
            'abbreviation.unique' => 'This abbreviation is already in use. Please choose a different one.',
            'abbreviation.regex' => 'Abbreviation must contain only lowercase letters and numbers with no spaces.',
        ]);

        // Handle status - for admins/super_admins it comes from select dropdown
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $validated['status'] = $request->input('status', 'active');
        } else {
            // For staff, keep as active (they can't edit status)
            $validated['status'] = 'active';
        }

        Unit::create($validated);

        return redirect()->route('units.index')->with('success', 'Unit added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        // Count all products (for display), but filter when loading
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $unit->loadCount('products');
            $products = $unit->products()
                ->with(['category'])
                ->orderBy('name')
                ->paginate(10);
        } else {
            // Staff can only see active products
            $unit->loadCount(['products' => function($query) {
                $query->where('status', 'active');
            }]);
            $products = $unit->products()
                ->where('status', 'active')
                ->with(['category'])
                ->orderBy('name')
                ->paginate(10);
        }

        return view('units.show', [
            'unit' => $unit,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $this->authorize('update', $unit);

        $unit->loadCount('products');

        return view('units.edit', ['unit' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $this->authorize('update', $unit);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'abbreviation' => 'required|max:10|unique:units,abbreviation,' . $unit->id . '|regex:/^[a-z0-9]+$/',
        ], [
            'abbreviation.required' => 'The abbreviation field is required.',
            'abbreviation.unique' => 'This abbreviation is already in use. Please choose a different one.',
            'abbreviation.regex' => 'Abbreviation must contain only lowercase letters and numbers with no spaces.',
        ]);

        // Handle status - for admins/super_admins it comes from select dropdown
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $newStatus = $request->input('status', 'active');
            
            // Prevent deactivating units that have active products
            if ($newStatus === 'inactive' && $unit->status === 'active') {
                $activeProductsCount = $unit->products()->where('status', 'active')->count();
                if ($activeProductsCount > 0) {
                    return back()->withErrors([
                        'status' => "Cannot deactivate this unit. It is currently being used by {$activeProductsCount} active product(s). Please change the products to use a different unit first."
                    ])->withInput();
                }
            }
            
            $validated['status'] = $newStatus;
        } else {
            // For staff, keep current status (they can't edit status)
            $validated['status'] = $unit->status;
        }

        $unit->update($validated);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $this->authorize('delete', $unit);

        // Prevent deletion of units that have products using them
        $productsCount = $unit->products()->count();
        if ($productsCount > 0) {
            return redirect()->route('units.index')
                ->with('error', "Cannot delete this unit. It is currently being used by {$productsCount} product(s). Please change those products to use a different unit first.");
        }

        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully!');
    }
}
