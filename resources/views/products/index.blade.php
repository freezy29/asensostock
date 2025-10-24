<x-layouts.app>
  <x-slot:title>Products</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Products</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                   Products
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

            @can('create', App\Models\Product::class)
            <x-ui.buttons.create href="{{ route('products.create') }}">
                Add Product
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <div class="overflow-x-auto m-8">
        <table class="table table-zebra table-lg">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                    @if (auth()->user()->role === 'admin')
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                <tr>
                    <td></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->unit->name }}</td>
                    <td>₱{{ $product->price }}</td>
                    <td>{{ $product->current_stock }}</td>

                    @if (auth()->user()->role === 'admin')
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
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="7" class="text-center text-gray-500 py-6">No products yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</x-layouts.app>
