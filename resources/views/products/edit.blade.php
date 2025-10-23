<x-layouts.app>
    <x-slot:title>Edit Product Details</x-slot:title>

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
                    <div class="bg-base-100 border border-base-300 rounded p-4 text-center text-base-content select-all">
                        {{ $product->created_at }}
                    </div>
                </div>
                <div>
                    <label class="label"><span class="label-text">Last updated</span></label>
                    <div class="bg-base-100 border border-base-300 rounded p-4 text-center text-base-content select-all">
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
                            <td>{{ $variant->measure->name }}</td>
                            <td class="text-center">{{ $variant->conversion_rate }}</td>
                            <td class="text-center">₱{{ number_format($variant->price, 2) }}</td>
                            <td class="text-center">{{ $variant->current_qty }}</td>
                            <td class="text-center">{{ $variant->critical_level }}</td>
                            <td class="text-center">{{ $variant->updated_at }}</td>
                            <td class="text-center">
                                <div class="inline-flex gap-2 justify-center">
                                    <!-- Edit variant action button -->
                                    <x-ui.action-icon type="edit" href="/variants/{{ $variant->id }}/edit" tooltip="Edit variant" />
                                    
                                    <!-- Restock action button -->
                                    <x-ui.action-icon type="restock" href="/variants/{{ $variant->id }}/restock" tooltip="Restock" />
                                    
                                    <!-- Delete variant action button -->
                                    <x-ui.action-icon type="delete" href="#" tooltip="Delete variant" />
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

</x-layouts.app>
