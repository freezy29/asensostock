<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::paginate(10);

        return view('transactions.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Transaction $transaction)
    {
        if ($request->user()->cannot('create', $transaction)) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
        ]);

        $validated['user_id'] = auth()->user()->id;
        $product = Product::find($validated['product_id']);

        // Validate product exists
        if (!$product) {
            return back()->withErrors(['product_id' => 'Selected product not found.']);
        }

        // Calculate new stock based on transaction type
        $newStock = 0;
        if ($validated['type'] === 'in') {
            $newStock = $product->stock_quantity + $validated['quantity'];
        } else {
            // Validate sufficient stock for stock out
            if ($product->stock_quantity < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Insufficient stock. Available: ' . $product->stock_quantity]);
            }
            $newStock = $product->stock_quantity - $validated['quantity'];
        }

        // Calculate cost_price and total_amount if provided, otherwise use defaults
        $costPrice = $product->cost_price ?? 0;
        $validated['cost_price'] = $costPrice;
        $validated['total_amount'] = $costPrice * $validated['quantity'];

        // Use database transaction to ensure data consistency
        DB::transaction(function () use ($validated, $product, $newStock) {
            $product->update(['stock_quantity' => $newStock]);
            Transaction::create($validated);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('transactions.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
