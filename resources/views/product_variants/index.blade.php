<x-layouts.app>
  <x-slot:title>Product Variants</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Variants</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                   Product Variants
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
                Create Variant
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <div class="overflow-x-auto m-8">
        <table class="table table-zebra table-lg">
            <!-- head -->
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Measure</th>
                    <th>Price</th>
                    <th>Current Stock</th>
                    @if (auth()->user()->role === 'admin')
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($variants as $variant)
                <tr>
                    <td>{{ $variant->product->name }}</td>
                    <td>{{ $variant->type->name }}</td>
                    <td>{{ $variant->measure->name }}</td>
                    <td> ₱{{ $variant->price }} </td>
                    <td>{{ $variant->current_qty }}</td>

                    @if (auth()->user()->role === 'admin')
                    <td>

                    @if(strtolower($variant->status) === 'active')
                      <span class="badge badge-success badge-md">Active</span>
                    @else
                      <span class="badge badge-ghost">{{ $variant->status }}</span>
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
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
