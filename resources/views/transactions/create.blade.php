<x-layouts.app>
  <x-slot:title>Record Transaction</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                <li>Record Transaction</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Record a Transaction</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
            @csrf

            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Transaction Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product -->
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text font-medium">Product</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_id"
                                        class="select select-bordered w-full @error('product_id') select-error @enderror"
                                        required>
                                    <option disabled selected value="">Select a product</option>
                                    @foreach(\App\Models\Product::where('status', 'active')->orderBy('name')->get() as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} (Stock: {{ $product->stock_quantity }}@if($product->unit->abbreviation) {{ $product->unit->abbreviation }}@endif)
                                        </option>
                                    @endforeach
                                </select>
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

                        <!-- Transaction Type -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Transaction Type</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <select name="type"
                                        class="select select-bordered w-full @error('type') select-error @enderror"
                                        required>
                                    <option disabled selected value="">Select type</option>
                                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                                </select>
                            </div>
                            @error('type')
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

                        <!-- Quantity -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Quantity</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="quantity"
                                       value="{{ old('quantity') }}"
                                       class="input input-bordered w-full @error('quantity') input-error @enderror"
                                       placeholder="0"
                                       min="1"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            @error('quantity')
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

                        <!-- Cost Price -->
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text font-medium">Cost Price</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <span class="z-1000 absolute left-3 top-1/2 transform -translate-y-1/2 text-base-content/60">₱</span>
                                <input type="number"
                                       name="cost_price"
                                       value="{{ old('cost_price') }}"
                                       class="input input-bordered w-full pl-8 @error('cost_price') input-error @enderror"
                                       placeholder="0.00"
                                       step="0.01"
                                       min="0"
                                       required />
                            </div>
                            @error('cost_price')
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

            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('transactions.index') }}"
                   class="btn btn-outline btn-lg flex-1 sm:flex-none min-h-12">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit"
                        class="btn btn-primary btn-lg flex-1 sm:flex-none min-h-12">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Record Transaction
                </button>
            </div>
        </form>
    </div>

</x-layouts.app>
