<x-layouts.app>
  <x-slot:title>Transactions</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Transactions</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Transactions
                </x-slot:page_title>

            <form method="GET" action="{{ route('transactions.index') }}" class="space-y-2">
                <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input placeholder="Search transactions..." />

                    <div class="flex justify-between gap-2">
                        <!-- Type Filter -->
                        <div class="form-control flex-1">
                            <select name="type" class="select select-bordered w-full min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('type') === '' ? 'selected' : '' }}>All Types</option>
                                <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stock In</option>
                                <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stock Out</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            @can('create', App\Models\Transaction::class)
            <x-ui.buttons.create href="{{ route('transactions.create') }}">
               Record Transaction
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4 m-4">
        @forelse ($transactions as $transaction)
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="card-title text-lg">
                                <a href="{{ route('products.show', $transaction->product->id) }}" class="link link-primary">
                                    {{ $transaction->product->name }}
                                </a>
                            </h3>
                            <p class="text-sm text-base-content/60">ID: {{ $transaction->id }}</p>
                        </div>
                        @if(strtolower($transaction->type) === 'in')
                            <span class="badge badge-success badge-md">In</span>
                        @else
                            <span class="badge badge-error badge-md">Out</span>
                        @endif
                    </div>
                    
                    <div class="space-y-2 text-sm">
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
                            <span class="font-medium text-primary">₱{{ number_format($transaction->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Processed By:</span>
                            <span class="font-medium">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</span>
                        </div>
                    </div>

                    <div class="card-actions justify-end mt-4">
                        <x-ui.buttons.view href="{{ route('transactions.show', $transaction->id) }}">
                        </x-ui.buttons.view>
                        @canany(['update', 'delete'], $transaction)
                            <x-ui.buttons.edit href="{{ route('transactions.edit', $transaction->id) }}">
                            </x-ui.buttons.edit>
                            
                        @endcanany
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                @if(request()->has('search') || request()->has('type'))
                    No transactions found matching your filters.
                @else
                    No transactions yet.
                @endif
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <x-ui.table class="hidden md:block">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Cost Price</th>
                    <th>Total Amount</th>
                    <th>Processed By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($transactions as $transaction)
                <tr>
                    <th>{{ $transaction->id }}</th>
                    <td>{{ $transaction->created_at->format('M d, Y g:i A') }}</td>
                    <td>
                        <a href="{{ route('products.show', $transaction->product->id) }}" class="link link-primary">
                            {{ $transaction->product->name }}
                        </a>
                    </td>
                    <td>
                    @if(strtolower($transaction->type) === 'in')
                      <span class="badge badge-success badge-md">In</span>
                    @else
                          <span class="badge badge-error badge-md">Out</span>
                    @endif
                    </td>
                    <td>{{ $transaction->quantity }} {{ $transaction->product->unit->abbreviation ?? '' }}</td>
                    <td>₱{{ number_format($transaction->cost_price, 2) }}</td>
                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                    <td>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                    <td>

                        <x-ui.buttons.view href="{{ route('transactions.show', $transaction->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $transaction)

                        <x-ui.buttons.edit href="{{ route('transactions.edit', $transaction->id) }}">
                        </x-ui.buttons.edit>
                        
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="9" class="text-center text-gray-500 py-6">
                    @if(request()->has('search') || request()->has('type'))
                        No transactions found matching your filters.
                    @else
                        No transactions yet.
                    @endif
                  </td>
                </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{ $transactions->onEachSide(5)->links() }}

</x-layouts.app>
