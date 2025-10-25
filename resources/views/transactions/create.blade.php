<x-layouts.app>
  <x-slot:title></x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                <li>Record Transaction</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Record a Transaction</h1>
        </div>
    </div>

    <div class="divider"></div>


</x-layouts.app>
