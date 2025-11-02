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
                <x-ui.search-input />
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
                    @if (auth()->user()->role === 'admin')
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
                    <td>₱{{ $product->price }}</td>
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

                    @if (auth()->user()->role !== 'staff')
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
