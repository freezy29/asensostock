<x-layouts.app>
  <x-slot:title>Transactions</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Transactions</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Transactions
                </x-slot:page_title>


            <label class="input">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g
                        stroke-linejoin="round"
                        stroke-linecap="round"
                        stroke-width="2.5"
                        fill="none"
                        stroke="currentColor"
                    >
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </g>
                </svg>
                <input type="search" required placeholder="Search" />
            </label>

            @can('create', App\Models\Transaction::class)
            <x-ui.buttons.create href="{{ route('transactions.create') }}">
               Record Transaction
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>


    <div class="overflow-x-auto m-8">
        <table class="table table-zebra table-lg">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
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
                    <td></td>
                    <td>{{ $transaction->id }}</td>
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
                    <td>₱{{ $transaction->cost_price }}</td>
                    <td>₱{{ $transaction->total_amount }}</td>
                    <td>{{ $transaction->user->first_name . " " . $transaction->user->last_name }}</td>
                    <td>

                        <x-ui.buttons.view href="{{ route('transactions.show', $transaction->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $transaction)

                        <x-ui.buttons.edit href="{{ route('transactions.edit', $transaction->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.delete action="{{ route('transactions.destroy', $transaction->id) }}">
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="6" class="text-center text-gray-500 py-6">No transactions yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>
