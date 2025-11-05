<x-layouts.app>
  <x-slot:title>Products</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Products</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                   Products
                </x-slot:page_title>

                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input placeholder="Search products..." />

                    <!-- Filters Toggle Button (Mobile only) -->
                    <button type="button"
                            onclick="document.getElementById('filters-container').classList.toggle('hidden'); this.querySelector('.filter-icon').classList.toggle('rotate-180');"
                            class="btn btn-outline md:hidden flex items-center gap-2">
                        <svg class="w-4 h-4 filter-icon transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        Filters
                        @if(request('category') || request('unit') || request('stock_status') || request('status'))
                            <span class="badge badge-primary badge-sm">{{ (request('category') ? 1 : 0) + (request('unit') ? 1 : 0) + (request('stock_status') ? 1 : 0) + (request('status') ? 1 : 0) }}</span>
                        @endif
                    </button>

                    <!-- Filters Container (Collapsible on Mobile, Inline on Desktop) -->
                    <div id="filters-container" class="hidden md:flex flex-col md:flex-row gap-2">
                        <!-- Category Filter -->
                        <div class="form-control">
                            <select name="category" class="select select-bordered w-full md:min-w-32" onchange="this.form.submit()">
                                <option value="" {{ request('category') === '' ? 'selected' : '' }}>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unit Filter -->
                        <div class="form-control">
                            <select name="unit" class="select select-bordered w-full md:min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('unit') === '' ? 'selected' : '' }}>All Units</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ request('unit') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}@if($unit->abbreviation) ({{ $unit->abbreviation }})@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="form-control">
                            <select name="stock_status" class="select select-bordered w-full md:min-w-32" onchange="this.form.submit()">
                                <option value="" {{ request('stock_status') === '' ? 'selected' : '' }}>All Stock Status</option>
                                <option value="critical" {{ request('stock_status') === 'critical' ? 'selected' : '' }}>Critical</option>
                                <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="ok" {{ request('stock_status') === 'ok' ? 'selected' : '' }}>In Stock</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                        <div class="form-control">
                            <select name="status" class="select select-bordered w-full md:min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </form>

                @can('create', App\Models\Product::class)
                <x-ui.buttons.create href="{{ route('products.create') }}">
                    Add Product
                </x-ui.buttons.create>
                @endcan

        </x-partials.header>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4 m-4">
        @forelse ($products as $product)
            <div class="card bg-base-100 shadow-md border border-base-300 overflow-visible">
                <div class="card-body overflow-visible">
                    <div class="flex justify-between items-start mb-2 gap-2">
                        <div class="flex-1 min-w-0">
                            <h3 class="card-title text-lg break-words">{{ $product->name }}</h3>
                            <p class="text-sm text-base-content/60">ID: {{ $product->id }}</p>
                        </div>
                        @php
                            $isCritical = $product->stock_quantity <= $product->critical_level;
                            $isLow = $product->stock_quantity <= ($product->critical_level * 1.5);
                        @endphp
                        <div class="flex-shrink-0">
                            @if($isCritical)
                                <span class="badge badge-error badge-md whitespace-nowrap">Critical</span>
                            @elseif($isLow)
                                <span class="badge badge-warning badge-md whitespace-nowrap">Low</span>
                            @else
                                <span class="badge badge-success badge-md whitespace-nowrap">In Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Category:</span>
                            <span class="font-medium">{{ $product->category->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Unit:</span>
                            <span class="font-medium">{{ $product->unit->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Price:</span>
                            <span class="font-medium">₱{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Stock:</span>
                            <span class="font-medium">{{ $product->stock_quantity }}</span>
                        </div>
                        @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Status:</span>
                            @if(strtolower($product->status) === 'active')
                                <span class="badge badge-success badge-sm">Active</span>
                            @else
                                <span class="badge badge-error badge-sm">Inactive</span>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div class="card-actions justify-end mt-4">
                        <x-ui.buttons.view href="{{ route('products.show', $product->id) }}">
                        </x-ui.buttons.view>
                        @canany(['update', 'delete'], $product)
                            <x-ui.buttons.edit href="{{ route('products.edit', $product->id) }}">
                            </x-ui.buttons.edit>
                            
                        @endcanany
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">No products yet.</div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <x-ui.table class="hidden md:block">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Stock Status</th>
                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->unit->name }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        @php
                            $isCritical = $product->stock_quantity <= $product->critical_level;
                            $isLow = $product->stock_quantity <= ($product->critical_level * 1.5);
                        @endphp
                        @if($isCritical)
                            <span class="badge badge-error badge-md">Critical</span>
                        @elseif($isLow)
                            <span class="badge badge-warning badge-md">Low</span>
                        @else
                            <span class="badge badge-success badge-md">In Stock</span>
                        @endif
                    </td>

                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <td>

                    @if(strtolower($product->status) === 'active')
                      <span class="badge badge-success badge-md">Active</span>
                    @else
                      <span class="badge badge-error badge-md">Inactive</span>
                    @endif

                    </td>
                    @endif
                    <td>

                        <x-ui.buttons.view href="{{ route('products.show', $product->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $product)

                        <x-ui.buttons.edit href="{{ route('products.edit', $product->id) }}">
                        </x-ui.buttons.edit>
                        
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="8" class="text-center text-gray-500 py-6">No products yet.</td>
                </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{ $products->onEachSide(5)->links() }}

</x-layouts.app>
