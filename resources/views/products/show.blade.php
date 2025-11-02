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
                            return confirm('Are you sure you want to delete this product?')
                        </x-slot:onclick>
                    </x-ui.buttons.delete>
                </div>
                @endcanany

        </x-partials.header>

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Product Overview Card -->
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <div class="flex items-center gap-6 mb-6">
                    <div class="avatar placeholder">
                        <div class="w-24 h-24 rounded-full bg-primary/10">
                            <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-base-content">{{ $product->name }}</h1>
                        <p class="text-lg text-base-content/70">{{ $product->category->name }}</p>
                        <div class="mt-2 flex gap-2">
                            @if(strtolower($product->status) === 'active')
                                <span class="badge badge-success badge-lg">Active</span>
                            @else
                                <span class="badge badge-error badge-lg">Inactive</span>
                            @endif
                            @php
                                $isCritical = $product->stock_quantity <= $product->critical_level;
                                $isLow = $product->stock_quantity <= ($product->critical_level * 1.5);
                            @endphp
                            @if($isCritical)
                                <span class="badge badge-error badge-lg">Critical Stock</span>
                            @elseif($isLow)
                                <span class="badge badge-warning badge-lg">Low Stock</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat bg-base-200 rounded-lg p-4">
                        <div class="stat-title">Stock Quantity</div>
                        <div class="stat-value text-2xl">{{ $product->stock_quantity }}</div>
                        <div class="stat-desc">{{ $product->unit->name }} ({{ $product->unit->abbreviation }})</div>
                    </div>

                    <div class="stat bg-base-200 rounded-lg p-4">
                        <div class="stat-title">Price</div>
                        <div class="stat-value text-2xl">₱{{ number_format($product->price, 2) }}</div>
                        <div class="stat-desc">Per {{ $product->unit->abbreviation }}</div>
                    </div>

                    <div class="stat bg-base-200 rounded-lg p-4">
                        <div class="stat-title">Critical Level</div>
                        <div class="stat-value text-2xl">{{ $product->critical_level }}</div>
                        <div class="stat-desc">{{ $product->unit->abbreviation }}</div>
                    </div>

                    <div class="stat bg-base-200 rounded-lg p-4">
                        <div class="stat-title">Total Value</div>
                        <div class="stat-value text-2xl">₱{{ number_format($product->stock_quantity * $product->price, 2) }}</div>
                        <div class="stat-desc">Current Inventory</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-success/10 rounded-lg">
                            <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-base-content/70">Total Stock In</div>
                            <div class="text-2xl font-bold">{{ $totalIn }}</div>
                            <div class="text-xs text-base-content/60">{{ $product->unit->abbreviation }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-error/10 rounded-lg">
                            <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-base-content/70">Total Stock Out</div>
                            <div class="text-2xl font-bold">{{ $totalOut }}</div>
                            <div class="text-xs text-base-content/60">{{ $product->unit->abbreviation }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-base-content/70">Total Cost Value</div>
                            <div class="text-2xl font-bold">₱{{ number_format($totalCostValue, 2) }}</div>
                            <div class="text-xs text-base-content/60">Stock In Transactions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="card-title text-xl">Product Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-base-content/70">Product ID</div>
                        <div class="font-medium">{{ $product->id }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-base-content/70">Category</div>
                        <div class="font-medium">{{ $product->category->name }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-base-content/70">Unit</div>
                        <div class="font-medium">{{ $product->unit->name }} ({{ $product->unit->abbreviation }})</div>
                    </div>

                    <div>
                        <div class="text-sm text-base-content/70">Status</div>
                        <div class="font-medium">
                            @if(strtolower($product->status) === 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-error">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-base-content/70">Created At</div>
                        <div class="font-medium">{{ $product->created_at->format('M d, Y g:i A') }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-base-content/70">Last Updated</div>
                        <div class="font-medium">{{ $product->updated_at->format('M d, Y g:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        @if($product->transactions->count() > 0)
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Recent Transactions</h2>
                    </div>
                    <a href="{{ route('transactions.index') }}?search={{ urlencode($product->name) }}" class="btn btn-sm btn-outline">
                        View All
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Cost Price</th>
                                <th>Total Amount</th>
                                <th>Processed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y g:i A') }}</td>
                                <td>
                                    @if(strtolower($transaction->type) === 'in')
                                        <span class="badge badge-success">In</span>
                                    @else
                                        <span class="badge badge-error">Out</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>₱{{ number_format($transaction->cost_price, 2) }}</td>
                                <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

</x-layouts.app>
