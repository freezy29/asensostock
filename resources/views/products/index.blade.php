<x-layouts.app>
  <x-slot:title>Products</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Products</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                   Products
                </x-slot:page_title>


            <form method="GET" action="{{ route('products.index') }}" class="space-y-2">
                <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input placeholder="Search products..." />

                    <div class="flex justify-between gap-2">
                        <!-- Category Filter -->
                        <div class="form-control flex-1">
                            <select name="category" class="select select-bordered w-full min-w-26" onchange="this.form.submit()">
                                <option value="" {{ request('category') === '' ? 'selected' : '' }}>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="form-control flex-1">
                            <select name="stock_status" class="select select-bordered w-full min-w-28" onchange="this.form.submit()">
                                <option value="" {{ request('stock_status') === '' ? 'selected' : '' }}>All Stock Status</option>
                                <option value="critical" {{ request('stock_status') === 'critical' ? 'selected' : '' }}>Critical</option>
                                <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="ok" {{ request('stock_status') === 'ok' ? 'selected' : '' }}>OK</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="form-control flex-1">
                            <select name="status" class="select select-bordered w-full min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            @can('create', App\Models\Product::class)
            <x-ui.buttons.create href="{{ route('products.create') }}">
                Add Product
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <x-ui.table>
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
                            <span class="badge badge-success badge-md">OK</span>
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

                        <x-ui.buttons.delete action="{{ route('products.destroy', $product->id) }}">
                            <x-slot:onclick>
                                return confirm('Are you sure you want to delete this product?')
                            </x-slot:onclick>
                        </x-ui.buttons.delete>
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
