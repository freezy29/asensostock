<x-layouts.app>
  <x-slot:title>Create Product Variant</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li>Add Variant</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Add a Product Variant</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('variants.store') }}" class="space-y-6">
            @csrf
            
            <!-- Product Selection Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Product Selection</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Product -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Product</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_id" 
                                        class="select select-bordered w-full @error('product_id') select-error @enderror" 
                                        required>
                                    <option disabled selected value="">Select a product</option>
                                    @foreach(\App\Models\Product::all() as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('product_id')
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

                        <!-- Variant Type -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Variant Type</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="variant_type_id" 
                                        class="select select-bordered w-full @error('variant_type_id') select-error @enderror" 
                                        required>
                                    <option disabled selected value="">Select variant type</option>
                                    @foreach(\App\Models\VariantType::all() as $variantType)
                                        <option value="{{ $variantType->id }}" {{ old('variant_type_id') == $variantType->id ? 'selected' : '' }}>
                                            {{ $variantType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('variant_type_id')
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

            <!-- Measurement Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-secondary/10 rounded-lg">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Measurement Details</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Measure Value -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Measure Value</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="measure_value"
                                       value="{{ old('measure_value') }}"
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full @error('measure_value') input-error @enderror"
                                       placeholder="0.00"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @error('measure_value')
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

                        <!-- Measure Unit -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Measure Unit</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="measure_unit_id" 
                                        class="select select-bordered w-full @error('measure_unit_id') select-error @enderror" 
                                        required>
                                    <option disabled selected value="">Select unit</option>
                                    @foreach(\App\Models\MeasureUnit::all() as $measureUnit)
                                        <option value="{{ $measureUnit->id }}" {{ old('measure_unit_id') == $measureUnit->id ? 'selected' : '' }}>
                                            {{ $measureUnit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            @error('measure_unit_id')
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

                    <!-- Conversion Rate -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Conversion Rate</span>
                            <span class="label-text-alt text-base-content/60">Optional</span>
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="conversion_rate"
                                   value="{{ old('conversion_rate') }}"
                                   min="1"
                                   class="input input-bordered w-full @error('conversion_rate') input-error @enderror"
                                   placeholder="1" />
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        @error('conversion_rate')
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

            <!-- Pricing & Inventory Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-accent/10 rounded-lg">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Pricing & Inventory</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
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

                        <!-- Current Quantity -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Current Quantity</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="current_qty"
                                       value="{{ old('current_qty', 0) }}"
                                       min="0"
                                       class="input input-bordered w-full @error('current_qty') input-error @enderror"
                                       placeholder="0"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @error('current_qty')
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
                                       value="{{ old('critical_level', 10) }}"
                                       min="0"
                                       class="input input-bordered w-full @error('critical_level') input-error @enderror"
                                       placeholder="10"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
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
                    Create Variant
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
