<x-layouts.app>
  <x-slot:title>Variants</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Variants</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                 Variants
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

            @can('create', App\Models\ProductVariant::class)
            <x-ui.buttons.create href="{{ route('variants.create') }}">
                Add Variant
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
                    <th>Variant Name</th>
                    <th>Category</th>
                    <th>Quantity per Unit</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    @if (auth()->user()->role === 'admin')
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($variants as $variant)
                <tr>
                    <td></td>
                    <td>{{ $variant->product->name }}</td>
                    <td>{{ $variant->name }}</td>
                    <td>{{ $variant->product->category->name }}</td>
                    <td>{{ $variant->quantity }}</td>
                    <td>₱{{ $variant->price }}</td>
                    <td>{{ $variant->stock_quantity }}</td>

                    @if (auth()->user()->role === 'admin')
                    <td>

                    @if(strtolower($variant->status) === 'active')
                      <span class="badge badge-success badge-md">Active</span>
                    @else
                      <span class="badge badge-error badge-md">Inactive</span>
                    @endif

                    </td>
                    @endif
                    <td>

                        <x-ui.buttons.view href="{{ route('variants.show', $variant->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $variant)

                        <x-ui.buttons.edit href="{{ route('variants.edit', $variant->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.delete action="{{ route('variants.destroy', $variant->id) }}">
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="9" class="text-center text-gray-500 py-6">No product variants yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</x-layouts.app>
