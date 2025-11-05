<x-layouts.app>
  <x-slot:title>Transaction Details</x-slot:title>

        <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                    <li>Transaction #{{ $transaction->id }}</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Transaction Details
                </x-slot:page_title>

                @canany(['update', 'delete'], $transaction)
                <div class="flex gap-2">
                    <x-ui.buttons.edit href="{{ route('transactions.edit', $transaction->id) }}">
                        Edit Transaction
                    </x-ui.buttons.edit>

                    <x-ui.buttons.delete action="{{ route('transactions.destroy', $transaction->id) }}">
                        <x-slot:onclick>
                            return confirm('Are you sure you want to delete this transaction? This will affect stock levels.')
                        </x-slot:onclick>
                    </x-ui.buttons.delete>
                </div>
                @endcanany

        </x-partials.header>

    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Transaction Header -->
                <div class="flex items-center gap-6 mb-8">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-base-content">Transaction #{{ $transaction->id }}</h1>
                        <p class="text-lg text-base-content/70">{{ $transaction->product->name }}</p>
                        <div class="mt-2">
                            @if(strtolower($transaction->type) === 'in')
                                <span class="badge badge-success badge-lg">Stock In</span>
                            @else
                                <span class="badge badge-error badge-lg">Stock Out</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Transaction Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Transaction Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Transaction Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm text-base-content/70">Transaction ID</div>
                                <div class="font-medium">{{ $transaction->id }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Type</div>
                                <div class="font-medium">
                                    @if(strtolower($transaction->type) === 'in')
                                        <span class="badge badge-success">Stock In</span>
                                    @else
                                        <span class="badge badge-error">Stock Out</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Quantity</div>
                                <div class="font-medium">{{ $transaction->quantity }}@if($transaction->product->unit->abbreviation) {{ $transaction->product->unit->abbreviation }}@endif</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Cost Price</div>
                                <div class="font-medium">₱{{ number_format($transaction->cost_price, 2) }}@if($transaction->product->unit->abbreviation) per {{ $transaction->product->unit->abbreviation }}@endif</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Total Amount</div>
                                <div class="font-medium text-lg">₱{{ number_format($transaction->total_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Product & User Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Related Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm text-base-content/70">Product</div>
                                <div class="font-medium">
                                    <a href="{{ route('products.show', $transaction->product->id) }}" class="link link-primary">
                                        {{ $transaction->product->name }}
                                    </a>
                                </div>
                                <div class="text-xs text-base-content/60">
                                    Category: {{ $transaction->product->category->name }}
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Current Stock</div>
                                <div class="font-medium">{{ $transaction->product->stock_quantity }}@if($transaction->product->unit->abbreviation) {{ $transaction->product->unit->abbreviation }}@endif</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Processed By</div>
                                <div class="font-medium">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</div>
                                <div class="text-xs text-base-content/60">{{ $transaction->user->email }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Transaction Date</div>
                                <div class="font-medium">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-base-content/60">{{ $transaction->created_at->format('g:i A') }}</div>
                            </div>

                            @if($transaction->created_at != $transaction->updated_at)
                            <div>
                                <div class="text-sm text-base-content/70">Last Updated</div>
                                <div class="font-medium">{{ $transaction->updated_at->format('M d, Y g:i A') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stock Impact Visualization -->
                <div class="mt-8 p-6 bg-base-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Stock Impact</h3>
                    <div class="flex items-center gap-4">
                        <div class="stat bg-base-100 rounded-lg p-4 flex-1 min-w-24">
                            <div class="stat-title text-wrap">Before Transaction</div>
                            <div class="stat-value text-xl">
                                @php
                                    $beforeStock = $transaction->type === 'in'
                                        ? $transaction->product->stock_quantity - $transaction->quantity
                                        : $transaction->product->stock_quantity + $transaction->quantity;
                                @endphp
                                {{ $beforeStock }}
                            </div>
                            <div class="stat-desc">@if($transaction->product->unit->abbreviation){{ $transaction->product->unit->abbreviation }}@endif</div>
                        </div>

                        <div class="flex-shrink-0">
                            @if($transaction->type === 'in')
                                <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                            @endif
                        </div>

                        <div class="stat bg-base-100 rounded-lg p-4 flex-1 min-w-24">
                            <div class="stat-title text-wrap">After Transaction</div>
                            <div class="stat-value text-xl">{{ $transaction->product->stock_quantity }}</div>
                            <div class="stat-desc">@if($transaction->product->unit->abbreviation){{ $transaction->product->unit->abbreviation }}@endif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
