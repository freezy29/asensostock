<x-layouts.app>
  <x-slot:title>Unit Details</x-slot:title>

        <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li><a href="{{ route('units.index') }}">Units</a></li>
                    <li>{{ $unit->name }}</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Unit Details
                </x-slot:page_title>

                @canany(['update', 'delete'], $unit)
                <div class="flex gap-2">
                    <x-ui.buttons.edit href="{{ route('units.edit', $unit->id) }}">
                        Edit Unit
                    </x-ui.buttons.edit>
                </div>
                @endcanany

        </x-partials.header>

    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Unit Header -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-base-300">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-base-content">{{ $unit->name }}</h1>
                        @if($unit->abbreviation)
                        <p class="text-base text-base-content/70 mt-1">{{ $unit->abbreviation }}</p>
                        @endif
                        <div class="mt-2 flex gap-2 flex-wrap">
                            @if(strtolower($unit->status) === 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-error">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Unit Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Unit ID</div>
                            <div class="font-medium">{{ $unit->id }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Unit Name</div>
                            <div class="font-medium text-lg">{{ $unit->name }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Number of Products</div>
                            <div class="font-medium text-lg">{{ $unit->products_count }}</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Abbreviation</div>
                            <div class="font-medium">{{ $unit->abbreviation }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Status</div>
                            <div class="font-medium">
                                @if(strtolower($unit->status) === 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-error">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Created At</div>
                            <div class="font-medium">{{ $unit->created_at->format('M d, Y') }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-base-content/70 mb-1">Last Updated</div>
                            <div class="font-medium">{{ $unit->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Products using this Unit -->
                @if($products->count() > 0)
                <div class="mt-6 pt-6 border-t border-base-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base">Products using this Unit</h3>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-ghost">
                            View All Products
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Stock Status</th>
                                    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                                    <th>Status</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="link link-primary">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>
                                        @php
                                            $isCritical = $product->stock_quantity <= $product->critical_level;
                                            $isLow = $product->stock_quantity <= ($product->critical_level * 1.5);
                                        @endphp
                                        @if($isCritical)
                                            <span class="badge badge-error badge-sm">Critical</span>
                                        @elseif($isLow)
                                            <span class="badge badge-warning badge-sm">Low</span>
                                        @else
                                            <span class="badge badge-success badge-sm">In Stock</span>
                                        @endif
                                    </td>
                                    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                                    <td>
                                        @if(strtolower($product->status) === 'active')
                                            <span class="badge badge-success badge-sm">Active</span>
                                        @else
                                            <span class="badge badge-error badge-sm">Inactive</span>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $products->links() }}
                </div>
                @else
                <div class="mt-6 pt-6 border-t border-base-300">
                    <div class="text-center py-8">
                        <p class="text-base-content/70">No products are using this unit yet.</p>
                        @can('create', App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mt-4">
                            Add Product
                        </a>
                        @endcan
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
