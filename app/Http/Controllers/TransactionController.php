<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['product.unit', 'user']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Apply type filter if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Apply date range filters if provided
        if ($request->filled('start_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        // Apply category filter if provided
        if ($request->filled('category')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

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
            'cost_price' => 'required|numeric|min:0',
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

        // Calculate total_amount
        $validated['total_amount'] = $validated['cost_price'] * $validated['quantity'];

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
    public function show(Transaction $transaction)
    {
        $transaction->load(['product', 'user']);

        return view('transactions.show', ['transaction' => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->load(['product.unit', 'user']);

        return view('transactions.edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        $validated['total_amount'] = $validated['cost_price'] * $validated['quantity'];

        // Get the old transaction values for stock recalculation
        $oldProduct = Product::find($transaction->product_id);
        $newProduct = Product::find($validated['product_id']);

        if (!$newProduct) {
            return back()->withErrors(['product_id' => 'Selected product not found.']);
        }

        // Use database transaction to ensure data consistency
        DB::transaction(function () use ($validated, $transaction, $oldProduct, $newProduct) {
            // Step 1: Revert the old transaction's stock impact on the old product
            if ($oldProduct) {
                if ($transaction->type === 'in') {
                    // Old transaction was stock in, so subtract the old quantity to revert
                    $oldProduct->stock_quantity -= $transaction->quantity;
                } else {
                    // Old transaction was stock out, so add back the old quantity to revert
                    $oldProduct->stock_quantity += $transaction->quantity;
                }
                $oldProduct->save();
            }

            // Step 2: Apply the new transaction's stock impact
            // Refresh newProduct to get current stock (which may have been affected if same product)
            $newProduct->refresh();

            // Check if we need to validate stock availability for stock out
            if ($validated['type'] === 'out') {
                if ($newProduct->stock_quantity < $validated['quantity']) {
                    throw new \Exception('Insufficient stock. Available: ' . $newProduct->stock_quantity);
                }
            }

            // Apply new transaction
            if ($validated['type'] === 'in') {
                $newProduct->stock_quantity += $validated['quantity'];
            } else {
                $newProduct->stock_quantity -= $validated['quantity'];
            }
            $newProduct->save();

            // Step 3: Update the transaction record
            $transaction->update($validated);
        });

        return redirect()->route('transactions.show', $transaction->id)
            ->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $product = $transaction->product;

        if (!$product) {
            return redirect()->route('transactions.index')
                ->with('error', 'Cannot delete transaction: Associated product not found.');
        }

        // Use database transaction to ensure data consistency
        DB::transaction(function () use ($transaction, $product) {
            // Revert the stock impact of this transaction
            if ($transaction->type === 'in') {
                // Transaction was stock in, so subtract to revert
                $product->stock_quantity -= $transaction->quantity;
            } else {
                // Transaction was stock out, so add back to revert
                $product->stock_quantity += $transaction->quantity;
            }

            // Ensure stock doesn't go negative (shouldn't happen, but safety check)
            if ($product->stock_quantity < 0) {
                throw new \Exception('Cannot delete transaction: Would result in negative stock.');
            }

            $product->save();
            $transaction->delete();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully. Stock has been adjusted.');
    }
}
