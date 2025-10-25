<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

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
            'product_id' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $validated['user_id'] = auth()->user()->id;
        $product = User::where('id', $validated['product_id']);

        if ($validated['type'] === 'in') {
            $validated['new_stock'] = $product->current_stock + $validated['quantity'];
        } else {
            $validated['new_stock'] = $product->current_stock - $validated['quantity'];
        }

        $validated['previous_stock'] = $product->current_stock;
        $product->update(['current_stock' => $validated['new_stock']]);
        Transaction::create($validated);

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
