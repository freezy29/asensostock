<x-layouts.app>
  <x-slot:title>Dashboard</x-slot:title>

    <x-partials.header>
        <x-slot:page_title>
          Dashboard
        </x-slot:page_title>
    </x-partials.header>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Products -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <h3 class="card-title text-sm text-base-content/70">Total Products</h3>
                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                <p class="text-sm text-base-content/60">Active products</p>
            </div>
        </div>

        <!-- Total Stock Value -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <h3 class="card-title text-sm text-base-content/70">Total Stock Value</h3>
                <p class="text-3xl font-bold">₱{{ number_format($totalStockValue, 2) }}</p>
                <p class="text-sm text-base-content/60">Current inventory value</p>
            </div>
        </div>

        <!-- Critical Stock -->
        <div class="card bg-base-100 shadow-md border border-error/20 bg-error/5">
            <div class="card-body">
                <h3 class="card-title text-sm text-error">Critical Stock</h3>
                <p class="text-3xl font-bold text-error">{{ $criticalStock }}</p>
                <p class="text-sm text-base-content/60">Products at critical level</p>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <h3 class="card-title text-sm text-base-content/70">Today's Transactions</h3>
                <p class="text-3xl font-bold">{{ $todayTransactions }}</p>
                <p class="text-sm text-base-content/60">
                    In: {{ number_format($todayStockIn) }} | Out: {{ number_format($todayStockOut) }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Stock Alerts Section -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-md border border-base-300 h-full">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="card-title">
                            Stock Alerts
                            @if($totalAlerts > 0)
                                <span class="badge badge-error ml-2">{{ $totalAlerts }}</span>
                            @endif
                        </h2>
                        <a href="{{ route('products.index', ['stock_status' => 'alerts', 'status' => 'active']) }}" class="btn btn-sm btn-outline">
                            View All
                        </a>
                    </div>

                    <!-- Critical Stock -->
                    @if($criticalProducts->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-error mb-3">Critical Stock ({{ $criticalStock }})</h3>
                            <div class="space-y-2">
                                @foreach($criticalProducts->take(5) as $product)
                                    <a href="{{ route('products.show', $product->id) }}" class="block p-3 bg-error/10 border border-error/20 rounded-lg hover:bg-error/20 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="font-medium">{{ $product->name }}</div>
                                                <div class="text-sm text-base-content/70">
                                                    Stock: {{ $product->stock_quantity }} {{ $product->unit->abbreviation ?? $product->unit->name }}
                                                    • Critical: {{ $product->critical_level }}
                                                </div>
                                            </div>
                                            <span class="badge badge-error">Critical</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Low Stock -->
                    @if($lowStockProducts->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-warning mb-3">Low Stock ({{ $lowStock }})</h3>
                            <div class="space-y-2">
                                @foreach($lowStockProducts->take(5) as $product)
                                    <a href="{{ route('products.show', $product->id) }}" class="block p-3 bg-warning/10 border border-warning/20 rounded-lg hover:bg-warning/20 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="font-medium">{{ $product->name }}</div>
                                                <div class="text-sm text-base-content/70">
                                                    Stock: {{ $product->stock_quantity }} {{ $product->unit->abbreviation ?? $product->unit->name }}
                                                    • Critical: {{ $product->critical_level }}
                                                </div>
                                            </div>
                                            <span class="badge badge-warning">Low</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($criticalProducts->count() === 0 && $lowStockProducts->count() === 0)
                        <div class="text-center py-8 text-base-content/70">
                            <svg class="w-16 h-16 mx-auto mb-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-lg font-medium">All stock levels are healthy!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-col gap-6">
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h2 class="card-title mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary w-full justify-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Transaction
                        </a>
                        @can('create', \App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="btn btn-outline w-full justify-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Product
                        </a>
                        @endcan
                        <a href="{{ route('reports.index') }}" class="btn btn-outline w-full justify-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            View Reports
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline w-full justify-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            All Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity Summary -->
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <h2 class="card-title mb-4">Activity Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-base-content/70">Today</span>
                            <span class="font-semibold">{{ $todayTransactions }} transactions</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-base-content/70">This Week</span>
                            <span class="font-semibold">{{ $weekTransactions }} transactions</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-base-content/70">This Month</span>
                            <span class="font-semibold">{{ $monthTransactions }} transactions</span>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="flex justify-between">
                            <span class="text-sm text-base-content/70">Stock In (Today)</span>
                            <span class="font-semibold text-success">{{ number_format($todayStockIn) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-base-content/70">Stock Out (Today)</span>
                            <span class="font-semibold text-error">{{ number_format($todayStockOut) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Transactions -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Recent Transactions</h2>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentTransactions->take(5) as $transaction)
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium">{{ $transaction->product->name }}</div>
                                <div class="text-sm text-base-content/70">
                                    {{ $transaction->quantity }} {{ $transaction->product->unit->abbreviation ?? '' }}
                                    • {{ $transaction->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($transaction->type === 'in')
                                    <span class="badge badge-success">In</span>
                                @else
                                    <span class="badge badge-error">Out</span>
                                @endif
                                @if(auth()->user()->role !== 'staff')
                                    <span class="text-xs text-base-content/70">{{ $transaction->user->first_name }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-base-content/70">
                            <p>No recent transactions</p>
                        </div>
                    @endforelse
                </div>
    </div>
</div>

        <!-- Top Products by Activity -->
        <div class="card bg-base-100 shadow-md border border-base-300">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">Most Active Products</h2>
                    <span class="text-sm text-base-content/70">Last 30 days</span>
                </div>
                <div class="space-y-3">
                    @forelse($topProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium">{{ $product->name }}</div>
                                <div class="text-sm text-base-content/70">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">{{ $product->transactions_count }}</div>
                                <div class="text-xs text-base-content/70">transactions</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-base-content/70">
                            <p>No activity data</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Trends Chart -->
    @if(count($transactionTrends) > 0)
    <div class="card bg-base-100 shadow-md border border-base-300">
        <div class="card-body">
            <h2 class="card-title mb-4">Transaction Trends (Last 7 Days)</h2>
            <div class="h-64">
                <canvas id="transactionTrendsChart"></canvas>
            </div>
        </div>
    </div>
    @endif

    <script>
        // Initialize Transaction Trends Chart
        document.addEventListener('DOMContentLoaded', function() {
            const trendsCtx = document.getElementById('transactionTrendsChart');
            if (trendsCtx && typeof Chart !== 'undefined') {
                const trendsData = @json($transactionTrends);
                
                new Chart(trendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.map(d => d.date),
                        datasets: [{
                            label: 'Stock In',
                            data: trendsData.map(d => d.in),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Stock Out',
                            data: trendsData.map(d => d.out),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 2,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

</x-layouts.app>
