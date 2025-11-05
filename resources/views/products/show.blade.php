<x-layouts.app>
  <x-slot:title>Product Details</x-slot:title>

        <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li>{{ $product->name }}</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Product Details
                </x-slot:page_title>

                @canany(['update', 'delete'], $product)
                <div class="flex gap-2">
                    <x-ui.buttons.edit href="{{ route('products.edit', $product->id) }}">
                        Edit Product
                    </x-ui.buttons.edit>

                    <x-ui.buttons.delete action="{{ route('products.destroy', $product->id) }}">
                        <x-slot:onclick>
                            @if($product->transactions()->count() > 0)
                                return confirm('Are you sure you want to delete this product? This product has {{ $product->transactions()->count() }} transaction(s). Products with transactions cannot be deleted. Consider deactivating it instead.')
                            @else
                                return confirm('Are you sure you want to delete this product?')
                            @endif
                        </x-slot:onclick>
                    </x-ui.buttons.delete>
                </div>
                @endcanany

        </x-partials.header>

    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Product Header -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-base-300">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-base-content">{{ $product->name }}</h1>
                        <p class="text-base text-base-content/70 mt-1">{{ $product->category->name }}</p>
                        <div class="mt-2 flex gap-2 flex-wrap">
                            @if(strtolower($product->status) === 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-error">Inactive</span>
                            @endif
                            @php
                                $isCritical = $product->stock_quantity <= $product->critical_level;
                                $isLow = $product->stock_quantity <= ($product->critical_level * 1.5);
                            @endphp
                            @if($isCritical)
                                <span class="badge badge-error">Critical</span>
                            @elseif($isLow)
                                <span class="badge badge-warning">Low</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Product ID</div>
                            <div class="font-medium">{{ $product->id }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Category</div>
                            <div class="font-medium">{{ $product->category->name }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Unit</div>
                            <div class="font-medium">{{ $product->unit->name }}@if($product->unit->abbreviation) ({{ $product->unit->abbreviation }})@endif</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Stock Quantity</div>
                            <div class="font-medium text-lg">{{ $product->stock_quantity }}@if($product->unit->abbreviation) {{ $product->unit->abbreviation }}@endif</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Price</div>
                            <div class="font-medium text-lg">₱{{ number_format($product->price, 2) }}@if($product->unit->abbreviation) per {{ $product->unit->abbreviation }}@endif</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Critical Level</div>
                            <div class="font-medium">{{ $product->critical_level }}@if($product->unit->abbreviation) {{ $product->unit->abbreviation }}@endif</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Total Inventory Value</div>
                            <div class="font-medium text-lg">₱{{ number_format($product->getCostValue(), 2) }}</div>
                            <div class="text-sm text-base-content/60">Retail: ₱{{ number_format($product->getRetailValue(), 2) }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Created At</div>
                            <div class="font-medium">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Summary -->
                @if($totalIn > 0 || $totalOut > 0)
                <div class="mt-6 pt-6 border-t border-base-300">
                    <h3 class="font-semibold text-base mb-4">Transaction Summary</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-base-content/70">Stock In</div>
                            <div class="text-xl font-bold mt-1">{{ $totalIn }} {{ $product->unit->abbreviation }}</div>
                        </div>
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-base-content/70">Stock Out</div>
                            <div class="text-xl font-bold mt-1">{{ $totalOut }} {{ $product->unit->abbreviation }}</div>
                        </div>
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-base-content/70">Total Cost Value</div>
                            <div class="text-xl font-bold mt-1">₱{{ number_format($totalCostValue, 2) }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Transactions -->
                @if($product->transactions->count() > 0)
                <div class="mt-6 pt-6 border-t border-base-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base">Recent Transactions</h3>
                        <a href="{{ route('transactions.index') }}?search={{ urlencode($product->name) }}" class="btn btn-sm btn-ghost">
                            View All
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Cost Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->transactions->take(5) as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(strtolower($transaction->type) === 'in')
                                            <span class="badge badge-success badge-sm">In</span>
                                        @else
                                            <span class="badge badge-error badge-sm">Out</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>₱{{ number_format($transaction->cost_price, 2) }}</td>
                                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
