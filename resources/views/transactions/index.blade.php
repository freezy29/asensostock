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
                <x-ui.search-input placeholder="Search by product name..." />
            </form>

            @can('create', App\Models\Transaction::class)
            <x-ui.buttons.create href="{{ route('transactions.create') }}">
               Record Transaction
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>



    <x-ui.table>
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
                    <td>{{ $transaction->product->name}}</td>
                    <td>

                    @if(strtolower($transaction->type) === 'in')
                      <span class="badge badge-success badge-md">In</span>
                    @else
                      <span class="badge badge-error">Out</span>
                    @endif

                    </td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>₱{{ number_format($transaction->cost_price, 2) }}</td>
                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                    <td>{{ $transaction->user->first_name . " " . $transaction->user->last_name }}</td>
                    <td>

                        <x-ui.buttons.view href="{{ route('transactions.show', $transaction->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $transaction)

                        <x-ui.buttons.edit href="{{ route('transactions.edit', $transaction->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.delete action="{{ route('transactions.destroy', $transaction->id) }}">
                            <x-slot:onclick>
                                return confirm('Are you sure you want to delete this transaction?')
                            </x-slot:onclick>
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="9" class="text-center text-gray-500 py-6">No transactions yet.</td>
                </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{ $transactions->onEachSide(5)->links() }}

</x-layouts.app>
