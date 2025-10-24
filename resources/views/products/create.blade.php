<x-layouts.app>
  <x-slot:title>Create Product</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li>Add Product</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Add a Product</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
            @csrf
            
            <!-- Product Information Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Product Information</h2>
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
                                       value="{{ old('name') }}"
                                       class="input input-bordered w-full @error('name') input-error @enderror"
                                       placeholder="Enter product name"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <option disabled selected value="">Select a category</option>
                                    @foreach(\App\Models\ProductCategory::where('status', 'active')->get() as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
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

                        <!-- Product Unit -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Product Unit</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_unit_id" 
                                        class="select select-bordered w-full @error('product_unit_id') select-error @enderror" 
                                        required>
                                    <option disabled selected value="">Select a unit</option>
                                    @foreach(\App\Models\ProductUnit::all() as $unit)
                                        <option value="{{ $unit->id }}" {{ old('product_unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
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

                        <!-- Product Packaging -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Product Packaging</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_packaging_id" 
                                        class="select select-bordered w-full @error('product_packaging_id') select-error @enderror" 
                                        required>
                                    <option disabled selected value="">Select packaging</option>
                                    @foreach(\App\Models\ProductPackaging::all() as $packaging)
                                        <option value="{{ $packaging->id }}" {{ old('product_packaging_id') == $packaging->id ? 'selected' : '' }}>
                                            {{ $packaging->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('product_packaging_id')
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
                                <input type="number" 
                                       name="price"
                                       value="{{ old('price') }}"
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full @error('price') input-error @enderror"
                                       placeholder="0.00"
                                       required />
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/40 font-bold text-lg">₱</span>
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

                        <!-- Current Stock -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Current Stock</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="current_stock"
                                       value="{{ old('current_stock', 0) }}"
                                       min="0"
                                       class="input input-bordered w-full @error('current_stock') input-error @enderror"
                                       placeholder="0"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @error('current_stock')
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

                        <!-- Reorder Level -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Reorder Level</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="reorder_level"
                                       value="{{ old('reorder_level', 10) }}"
                                       min="0"
                                       class="input input-bordered w-full @error('reorder_level') input-error @enderror"
                                       placeholder="10"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            @error('reorder_level')
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Product
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
