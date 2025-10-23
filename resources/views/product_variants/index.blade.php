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
            <x-ui.create-button href="{{ route('variants.create') }}">
                Create Variant
            </x-ui.create-button>
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

                    <div class="tooltip" data-tip="View Details">
                        <a href="{{ route('variants.show', $variant->id) }}" class="btn btn-square">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </a>
                    </div>


                    @canany(['update', 'delete'], $variant)
                    <div class="tooltip" data-tip="Edit">
                        <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-square">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20l4-1 11-11-3-3L6 16l-2 4z" />
                          </svg>
                        </a>
                    </div>

                        <div class="tooltip" data-tip="Delete">
                        <form method="POST" action="{{ route('variants.destroy', $variant->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to delete this product variant?')"
                                class="btn btn-square">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7l1-3h4l1 3" />
                              </svg>
                            </button>
                            </form>
                        </div>
                        @endcanany

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
