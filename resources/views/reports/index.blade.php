<x-layouts.app>
  <x-slot:title>Reports</x-slot:title>

    <x-partials.header>
        <x-slot:breadcrumb_list>
            <li>Reports</li>
        </x-slot:breadcrumb_list>

        <x-slot:page_title>
          Reports
        </x-slot:page_title>

        <!-- Date Range Filter -->
        <form method="GET" action="{{ route('reports.index') }}" class="space-y-3 md:space-y-0">
            <div class="flex flex-col md:flex-row gap-3 md:items-end">
                <div class="form-control w-full md:flex-1">
                    <label class="label py-1">
                        <span class="label-text text-sm font-medium">Start Date</span>
                    </label>
                    <input type="date"
                           name="start_date"
                           value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                           class="input input-bordered w-full">
                </div>
                <div class="form-control w-full md:flex-1">
                    <label class="label py-1">
                        <span class="label-text text-sm font-medium">End Date</span>
                    </label>
                    <input type="date"
                           name="end_date"
                           value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                           class="input input-bordered w-full">
                </div>
                <div class="form-control w-full md:flex-1">
                    <label class="label py-1">
                        <span class="label-text text-sm font-medium">Category</span>
                    </label>
                    <select name="category" class="select select-bordered w-full">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control w-full md:flex-1">
                    <label class="label py-1">
                        <span class="label-text text-sm font-medium">Transaction Type</span>
                    </label>
                    <select name="transaction_type" class="select select-bordered w-full">
                        <option value="">All Types</option>
                        <option value="in" {{ request('transaction_type') == 'in' ? 'selected' : '' }}>Stock In</option>
                        <option value="out" {{ request('transaction_type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                    </select>
                </div>
                <div class="form-control w-full md:w-auto flex flex-row gap-2">
                    <button type="submit" class="btn btn-primary flex-1 md:flex-none">Apply Filters</button>
                    @if(request()->has('start_date') || request()->has('end_date') || request()->has('category') || request()->has('transaction_type'))
                        <a href="{{ route('reports.index') }}" class="btn btn-outline flex-1 md:flex-none">Clear</a>
                    @endif
                    <button onclick="window.print()" class="btn btn-outline flex-1 md:flex-none print:hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                    @if($canExport)
                    <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'all'])) }}"
                       class="btn btn-outline flex-1 md:flex-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export All
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </x-partials.header>

    <!-- Tabs Navigation -->
    <div class="tabs tabs-boxed mb-6">
        <a href="#stock" class="tab tab-active">Stock Reports</a>
        <a href="#transactions" class="tab">Transaction Reports</a>
    @if($canViewFinancial)
        <a href="#financial" class="tab">Financial Reports</a>
    @endif
        <a href="#analytics" class="tab">Analytics</a>
    </div>

    <!-- Stock Reports Section -->
    <div id="stock" class="tab-content" style="display: block;">
        <div class="print-only mb-6">
            <h1 class="text-3xl font-bold mb-2">Stock Reports</h1>
            <div class="text-sm text-base-content/70 mb-4">
                Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Products Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Total Products</h3>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                    <p class="text-sm text-base-content/60">{{ $activeProducts }} active</p>
                </div>
            </div>

            <!-- Total Stock Value Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Total Stock Value (Cost)</h3>
                    <p class="text-3xl font-bold">₱{{ number_format($totalStockValue, 2) }}</p>
                    @if(isset($totalRetailValue) && $totalRetailValue > $totalStockValue)
                        <p class="text-xs text-base-content/50 mt-1">Retail: ₱{{ number_format($totalRetailValue, 2) }}</p>
                    @endif
                    <p class="text-sm text-base-content/60">Current inventory value</p>
                </div>
            </div>

            <!-- Critical Stock Card -->
            <div class="card bg-base-100 shadow-md border border-error/20 bg-error/5">
                <div class="card-body">
                    <h3 class="card-title text-sm text-error">Critical Stock</h3>
                    <p class="text-3xl font-bold text-error">{{ $criticalStock }}</p>
                    <p class="text-sm text-base-content/60">Products at critical level</p>
                </div>
            </div>

            <!-- Low Stock Card -->
            <div class="card bg-base-100 shadow-md border border-warning/20 bg-warning/5">
                <div class="card-body">
                    <h3 class="card-title text-sm text-warning">Low Stock</h3>
                    <p class="text-3xl font-bold text-warning">{{ $lowStock }}</p>
                    <p class="text-sm text-base-content/60">Products below 1.5x critical</p>
                </div>
            </div>
        </div>

        <!-- Low Stock Products Table -->
        <div class="card bg-base-100 shadow-md border border-base-300 mb-6">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Low Stock Products</h2>
                    @if($canExport)
                    <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'stock'])) }}"
                       class="btn btn-sm btn-outline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export CSV
                    </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Critical Level</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->stock_quantity }} {{ $product->unit->abbreviation ?? $product->unit->name }}</td>
                                    <td>{{ $product->critical_level }}</td>
                                    <td>
                                        @if($product->stock_quantity <= $product->critical_level)
                                            <span class="badge badge-error">Critical</span>
                                        @else
                                            <span class="badge badge-warning">Low</span>
                                        @endif
                                    </td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-6">No low stock products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Stock by Category -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <h2 class="card-title mb-4">Stock by Category</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Number of Products</th>
                                <th>Total Quantity</th>
                                <th>Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockByCategory as $category)
                                <tr>
                                    <td>{{ $category['name'] }}</td>
                                    <td>{{ $category['products_count'] }}</td>
                                    <td>{{ number_format($category['total_quantity']) }}</td>
                                    <td>₱{{ number_format($category['total_value'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-6">No data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Reports Section -->
    <div id="transactions" class="tab-content" style="display: none;">
        <div class="print-only mb-6">
            <h1 class="text-3xl font-bold mb-2">Transaction Reports</h1>
            <div class="text-sm text-base-content/70 mb-4">
                Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Transactions Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Total Transactions</h3>
                    <p class="text-3xl font-bold">{{ $totalTransactions }}</p>
                    <p class="text-sm text-base-content/60">From {{ $startDate->format('M d') }} to {{ $endDate->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Stock In Card -->
            <div class="card bg-base-100 shadow-md border border-success/20 bg-success/5">
                <div class="card-body">
                    <h3 class="card-title text-sm text-success">Stock In</h3>
                    <p class="text-3xl font-bold text-success">{{ $stockInCount }}</p>
                    <p class="text-sm text-base-content/60">Quantity: {{ number_format($stockInQuantity) }}</p>
                </div>
            </div>

            <!-- Stock Out Card -->
            <div class="card bg-base-100 shadow-md border border-error/20 bg-error/5">
                <div class="card-body">
                    <h3 class="card-title text-sm text-error">Stock Out</h3>
                    <p class="text-3xl font-bold text-error">{{ $stockOutCount }}</p>
                    <p class="text-sm text-base-content/60">Quantity: {{ number_format($stockOutQuantity) }}</p>
                </div>
            </div>

            <!-- Net Movement Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Net Movement</h3>
                    <p class="text-3xl font-bold {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? 'text-success' : 'text-error' }}">
                        {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? '+' : '' }}{{ number_format($stockInQuantity - $stockOutQuantity) }}
                    </p>
                    <p class="text-sm text-base-content/60">Net stock change</p>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 mb-4">
                    <h2 class="card-title">Recent Transactions</h2>
                    <div class="flex flex-row gap-2 w-full md:w-auto">
                        <a href="{{ route('transactions.index', array_filter([
                            'start_date' => request('start_date'),
                            'end_date' => request('end_date'),
                            'category' => request('category'),
                            'type' => request('transaction_type')
                        ])) }}"
                           class="btn btn-sm btn-outline flex-1 md:flex-none">
                            View All
                        </a>
                        @if($canExport)
                        <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'transactions'])) }}"
                           class="btn btn-sm btn-outline flex-1 md:flex-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export CSV
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3">
                    @forelse($recentTransactions as $transaction)
                        <div class="card bg-base-200 overflow-visible">
                            <div class="card-body gap-2">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1 min-w-0 break-words">
                                        <h3 class="font-semibold text-base">{{ $transaction->product->name }}</h3>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($transaction->type === 'in')
                                            <span class="badge badge-success whitespace-nowrap">In</span>
                                        @else
                                            <span class="badge badge-error whitespace-nowrap">Out</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Date:</span>
                                        <span class="font-medium">{{ $transaction->created_at->format('M d, Y g:i A') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Quantity:</span>
                                        <span class="font-medium">{{ $transaction->quantity }} {{ $transaction->product->unit->abbreviation ?? '' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Cost Price:</span>
                                        <span class="font-medium">₱{{ number_format($transaction->cost_price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Total Amount:</span>
                                        <span class="font-medium">₱{{ number_format($transaction->total_amount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Processed By:</span>
                                        <span class="font-medium">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">No transactions found.</div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Cost Price</th>
                                <th>Total Amount</th>
                                <th>Processed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y g:i A') }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td>
                                        @if($transaction->type === 'in')
                                            <span class="badge badge-success">In</span>
                                        @else
                                            <span class="badge badge-error">Out</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->quantity }} {{ $transaction->product->unit->abbreviation ?? '' }}</td>
                                    <td>₱{{ number_format($transaction->cost_price, 2) }}</td>
                                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                    <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Reports Section -->
    @if($canViewFinancial)
    <div id="financial" class="tab-content" style="display: none;">
        <div class="print-only mb-6">
            <h1 class="text-3xl font-bold mb-2">Financial Reports</h1>
            <div class="text-sm text-base-content/70 mb-4">
                Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Total Cost Value Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Total Cost Value (Stock Ins)</h3>
                    <p class="text-3xl font-bold">₱{{ number_format($totalCostValue, 2) }}</p>
                    <p class="text-sm text-base-content/60">Total cost of stock-in transactions</p>
                </div>
            </div>

            <!-- Current Inventory Value Card -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h3 class="card-title text-sm text-base-content/70">Current Inventory Value</h3>
                    <p class="text-3xl font-bold">₱{{ number_format($totalStockValue, 2) }}</p>
                    <p class="text-sm text-base-content/60">Total value of current stock</p>
                </div>
            </div>
        </div>

        <!-- Top Products by Transactions -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Most Active Products</h2>
                    @if($canExport)
                    <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'financial'])) }}"
                       class="btn btn-sm btn-outline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export CSV
                    </a>
                    @endif
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3">
                    @forelse($topProducts as $product)
                        <div class="card bg-base-200 overflow-visible">
                            <div class="card-body gap-2">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1 min-w-0 break-words">
                                        <h3 class="font-semibold text-base">{{ $product->name }}</h3>
                                        <p class="text-sm text-base-content/70">{{ $product->category->name }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge badge-primary whitespace-nowrap">{{ $product->transactions_count }} transactions</span>
                                    </div>
                                </div>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Current Stock:</span>
                                        <span class="font-medium">{{ $product->stock_quantity }} {{ $product->unit->abbreviation ?? $product->unit->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Price:</span>
                                        <span class="font-medium">₱{{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Stock Value (Cost):</span>
                                        <span class="font-medium">₱{{ number_format($product->getCostValue(), 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-base-content/70">Stock Value (Retail):</span>
                                        <span class="font-medium">₱{{ number_format($product->getRetailValue(), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">No products found.</div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Selling Price</th>
                                <th>Avg Cost</th>
                                <th>Stock Value (Cost)</th>
                                <th>Stock Value (Retail)</th>
                                <th>Transaction Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->stock_quantity }} {{ $product->unit->abbreviation ?? $product->unit->name }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>₱{{ number_format($product->getAverageCostPrice(), 2) }}</td>
                                    <td>₱{{ number_format($product->getCostValue(), 2) }}</td>
                                    <td>₱{{ number_format($product->getRetailValue(), 2) }}</td>
                                    <td>{{ $product->transactions_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-6">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Analytics Section -->
    <div id="analytics" class="tab-content" style="display: none;">
        <div class="print-only mb-6">
            <h1 class="text-3xl font-bold mb-2">Analytics</h1>
            <div class="text-sm text-base-content/70 mb-4">
                Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Stock Status Chart -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h2 class="card-title mb-4">Stock Status Distribution</h2>
                    <div class="h-64 relative">
                        <canvas id="stockStatusChart" style="max-height: 256px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transaction Summary Chart -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h2 class="card-title mb-4">Transaction Summary</h2>
                    <div class="h-64 relative">
                        <canvas id="transactionChart" style="max-height: 256px;"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <div class="text-2xl font-bold {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? 'text-success' : 'text-error' }}">
                            Net: {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? '+' : '' }}{{ number_format($stockInQuantity - $stockOutQuantity) }}
                        </div>
                        <p class="text-sm text-base-content/60">Net stock change</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <h2 class="card-title mb-4">Summary Statistics</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold mb-2">Stock Status</h3>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span>Active Products:</span>
                                <span class="font-medium">{{ $activeProducts }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Zero Stock:</span>
                                <span class="font-medium text-error">{{ $zeroStock }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Critical Stock:</span>
                                <span class="font-medium text-error">{{ $criticalStock }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Low Stock:</span>
                                <span class="font-medium text-warning">{{ $lowStock }}</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Transaction Summary</h3>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span>Total Transactions:</span>
                                <span class="font-medium">{{ $totalTransactions }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Stock In:</span>
                                <span class="font-medium text-success">{{ $stockInCount }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Stock Out:</span>
                                <span class="font-medium text-error">{{ $stockOutCount }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Net Quantity:</span>
                                <span class="font-medium {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? 'text-success' : 'text-error' }}">
                                    {{ ($stockInQuantity - $stockOutQuantity) >= 0 ? '+' : '' }}{{ number_format($stockInQuantity - $stockOutQuantity) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize: show first tab by default (already visible via inline style)
            // Just ensure all others are hidden
            document.querySelectorAll('.tab-content').forEach((content, index) => {
                if (index !== 0) {
                    content.style.display = 'none';
                }
            });

            // Tab click handlers
            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all tabs
                    document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('tab-active'));
                    // Hide all tab contents
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.style.display = 'none';
                    });

                    // Add active class to clicked tab
                    this.classList.add('tab-active');

                    // Show corresponding content
                    const targetId = this.getAttribute('href').substring(1);
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.style.display = 'block';
                        // Reinitialize charts if Analytics tab is opened
                        if (targetId === 'analytics') {
                            initCharts();
                        }
                    }
                });
            });

            // Store chart instances to prevent duplicates
            let stockChartInstance = null;
            let transactionChartInstance = null;

            // Initialize charts when Analytics tab is first loaded
            function initCharts() {
                // Destroy existing charts if they exist
                if (stockChartInstance) {
                    stockChartInstance.destroy();
                    stockChartInstance = null;
                }
                if (transactionChartInstance) {
                    transactionChartInstance.destroy();
                    transactionChartInstance = null;
                }

                // Small delay to ensure tab content is visible and has proper dimensions
                setTimeout(() => {
                    // Stock Status Pie Chart
                    const stockCtx = document.getElementById('stockStatusChart');
                    if (stockCtx && typeof Chart !== 'undefined') {
                        // Set canvas dimensions explicitly
                        const stockContainer = stockCtx.parentElement;
                        if (stockContainer) {
                            stockCtx.width = stockContainer.offsetWidth;
                            stockCtx.height = stockContainer.offsetHeight;
                        }

                        stockChartInstance = new Chart(stockCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Active', 'Critical', 'Low', 'Zero Stock'],
                                datasets: [{
                                    data: [{{ $activeProducts }}, {{ $criticalStock }}, {{ $lowStock }}, {{ $zeroStock }}],
                                    backgroundColor: [
                                        'rgb(34, 197, 94)', // green for active
                                        'rgb(239, 68, 68)', // red for critical
                                        'rgb(251, 191, 36)', // yellow for low
                                        'rgb(156, 163, 175)' // gray for zero
                                    ],
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 1.5,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.label + ': ' + context.parsed + ' products';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Transaction Bar Chart
                    const transCtx = document.getElementById('transactionChart');
                    if (transCtx && typeof Chart !== 'undefined') {
                        // Set canvas dimensions explicitly
                        const transContainer = transCtx.parentElement;
                        if (transContainer) {
                            transCtx.width = transContainer.offsetWidth;
                            transCtx.height = transContainer.offsetHeight;
                        }

                        transactionChartInstance = new Chart(transCtx, {
                            type: 'bar',
                            data: {
                                labels: ['Stock In', 'Stock Out'],
                                datasets: [{
                                    label: 'Count',
                                    data: [{{ $stockInCount }}, {{ $stockOutCount }}],
                                    backgroundColor: [
                                        'rgb(34, 197, 94)',
                                        'rgb(239, 68, 68)'
                                    ],
                                    borderWidth: 1
                                }, {
                                    label: 'Quantity',
                                    data: [{{ $stockInQuantity }}, {{ $stockOutQuantity }}],
                                    backgroundColor: [
                                        'rgba(34, 197, 94, 0.5)',
                                        'rgba(239, 68, 68, 0.5)'
                                    ],
                                    borderWidth: 1,
                                    yAxisID: 'y1'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 1.5,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Count'
                                        }
                                    },
                                    y1: {
                                        type: 'linear',
                                        display: true,
                                        position: 'right',
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Quantity'
                                        },
                                        grid: {
                                            drawOnChartArea: false
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                if (context.datasetIndex === 0) {
                                                    return 'Count: ' + context.parsed.y;
                                                } else {
                                                    return 'Quantity: ' + context.parsed.y.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                }, 100); // Small delay to ensure DOM is ready
            }

            // Initialize charts if Analytics tab is visible on load
            const analyticsTab = document.getElementById('analytics');
            if (analyticsTab && analyticsTab.style.display !== 'none') {
                initCharts();
            }
        });
    </script>

    <style>
        @media print {
            .print\\:hidden { display: none !important; }
            .print-only { display: block !important; }
            .tabs { display: none !important; }
            .tab-content { 
                display: block !important; 
                page-break-inside: avoid;
                margin-bottom: 2rem;
            }
            .tab-content:not(:last-child) { 
                page-break-after: always; 
            }
            .tab-content:last-child { 
                page-break-after: auto; 
            }
            h1 {
                page-break-after: avoid;
            }
            .card {
                page-break-inside: avoid;
                margin-bottom: 1rem;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
        }
        @media screen {
            .print-only { display: none !important; }
        }
    </style>

</x-layouts.app>
