<x-layouts.app>
  <x-slot:title>Edit Product</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li>Edit Product</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Edit Product</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Single Product Form Card -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Edit Product</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Product Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Product Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $product->name) }}"
                                       class="input input-bordered w-full pr-10 @error('name') input-error @enderror"
                                       placeholder="Enter product name"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <!-- Product Category -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Product Category</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_category_id"
                                        class="select select-bordered w-full @error('product_category_id') select-error @enderror"
                                        required>
                                    <option disabled value="">Select a category</option>
                                    @foreach(\App\Models\Category::where('status', 'active')->get() as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('product_category_id')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <!-- Unit -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Unit</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_unit_id"
                                        class="select select-bordered w-full @error('product_unit_id') select-error @enderror"
                                        required>
                                    <option disabled value="">Select a unit</option>
                                    @foreach(\App\Models\Unit::where('status', 'active')->get() as $unit)
                                        <option value="{{ $unit->id }}" {{ old('product_unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}@if($unit->abbreviation) ({{ $unit->abbreviation }})@endif
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('product_unit_id')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    @php
                        $transactionsCount = $product->transactions()->count();
                    @endphp
                    @if($transactionsCount > 0)
                    <div class="alert alert-warning mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span><strong>Note:</strong> Changing the stock quantity will automatically create a stock adjustment transaction to maintain the audit trail.</span>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Stock Quantity -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Stock Quantity</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="stock_quantity"
                                       value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                       class="input input-bordered w-full pr-10 @error('stock_quantity') input-error @enderror"
                                       placeholder="0"
                                       min="0"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @error('stock_quantity')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <!-- Critical Level -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Critical Level</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="critical_level"
                                       value="{{ old('critical_level', $product->critical_level) }}"
                                       class="input input-bordered w-full pr-10 @error('critical_level') input-error @enderror"
                                       placeholder="10"
                                       min="0"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            @if(old('critical_level', $product->critical_level) > old('stock_quantity', $product->stock_quantity))
                            <label class="label">
                                <span class="label-text-alt text-warning flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Critical level is higher than current stock. This will trigger stock warnings immediately.
                                </span>
                            </label>
                            @endif
                            @error('critical_level')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Price</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base-content font-medium z-10 pointer-events-none">₱</span>
                                <input type="number"
                                       name="price"
                                       value="{{ old('price', $product->price) }}"
                                       class="input input-bordered w-full pl-8 @error('price') input-error @enderror"
                                       placeholder="0.00"
                                       step="0.01"
                                       min="0.01"
                                       required />
                            </div>
                            @error('price')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Field -->
                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Status</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <div class="relative">
                            <select name="status"
                                    class="select select-bordered w-full @error('status') select-error @enderror"
                                    required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        @error('status')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('products.index') }}"
                   class="btn btn-outline btn-sm md:btn-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit"
                        class="btn btn-primary btn-sm md:btn-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Product
                </button>
            </div>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mt-6 max-w-2xl mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h3 class="font-bold">Please correct the following errors:</h3>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</x-layouts.app>
