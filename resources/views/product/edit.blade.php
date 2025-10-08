
<x-layout>
    <x-slot:title>Product Details</x-slot:title>

    <div class="mb-6">
        <h1 class="text-4xl font-bold">Product details</h1>
        <p class="text-sm text-gray-500 mt-1">Edit product information and manage variants</p>
    </div>

    <form method="POST" action="{{ url('/products/' . $product->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="label">
                    <span class="label-text">Product name</span>
                </label>
                <input name="name" type="text" class="input input-bordered w-full" value="{{ old('name', $product->name) }}" required />
            </div>

            <div>
                <label class="label">
                    <span class="label-text">Category</span>
                </label>
                <select name="category_id" class="select select-bordered w-full">
                    <option value="{{ $product->category->id ?? '' }}">{{ $product->category->name ?? 'Uncategorized' }}</option>
                </select>
            </div>

            <div class="flex items-center gap-4">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <input type="hidden" name="status" value="0" />
                <input type="checkbox" name="status" value="1" class="toggle" {{ $product->status == 'active' || $product->status == 1 ? 'checked' : '' }} />
                <span class="text-sm text-gray-500">Active</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="label"><span class="label-text">Created at</span></label>
                    <div class="bg-white border border-base-200 rounded p-4 text-center text-gray-600 select-all">
                        {{ $product->created_at }}
                    </div>
                </div>
                <div>
                    <label class="label"><span class="label-text">Last updated</span></label>
                    <div class="bg-white border border-base-200 rounded p-4 text-center text-gray-600 select-all">
                        {{ $product->updated_at }}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="/products" class="btn btn-ghost">Cancel</a>
        </div>
    </form>


    <section class="mt-8">
        <h2 class="text-xl font-semibold mb-3">Variants</h2>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table w-full table-zebra text-sm sm:text-base">
                <thead>
                    <tr>
                        <th>Variant Type</th>
                        <th class="text-center">Measure</th>
                        <th>Unit</th>
                        <th class="text-center">Conversion</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Critical</th>
                        <th class="text-center">Last Updated</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variants as $variant)
                        <tr class="align-middle">
                            <td class="font-medium">{{ $variant->type->name }}</td>
                            <td class="text-center">{{ (int) $variant->measure_value }}</td>
                            <td>{{ $variant->unit->name }}</td>
                            <td class="text-center">{{ $variant->conversion_rate }}</td>
                            <td class="text-center">₱{{ number_format($variant->price, 2) }}</td>
                            <td class="text-center">{{ $variant->current_qty }}</td>
                            <td class="text-center">{{ $variant->critical_level }}</td>
                            <td class="text-center">{{ $variant->updated_at }}</td>
                            <td class="text-center">
                                <div class="inline-flex gap-2 justify-center">
                                    <div class="tooltip" data-tip="Edit variant">
                                        <a href="/variants/{{ $variant->id }}/edit" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-yellow-50 transition" title="Edit variant">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20l4-1 11-11-3-3L6 16l-2 4z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="tooltip" data-tip="Restock">
                                        <a href="/variants/{{ $variant->id }}/restock" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-green-50 transition" title="Restock" aria-label="Restock">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <!-- circular refresh / restock icon -->
                                                <path stroke-linecap="round" stroke-linejoin="round" opacity="0.25" d="M12 3a9 9 0 100 18 9 9 0 000-18z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 3v6h-6" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="tooltip" data-tip="Delete variant">
                                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-red-50 transition" title="Delete variant">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7l1-3h4l1 3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-6">No variants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-layout>

