<x-layouts.app>
  <x-slot:title>Edit Unit</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('units.index') }}">Units</a></li>
                <li>Edit Unit</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Edit Unit</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('units.update', $unit->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Unit Form Card -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Edit Unit</h2>
                    </div>

                    @if($unit->products_count > 0)
                    <div class="alert alert-warning mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span>This unit is currently being used by <strong>{{ $unit->products_count }}</strong> product(s). Changes to the name or abbreviation will affect all products using this unit.</span>
                    </div>
                    @endif

                    <div class="space-y-6">
                        <!-- Unit Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Unit Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $unit->name) }}"
                                       class="input input-bordered w-full pr-10 @error('name') input-error @enderror"
                                       placeholder="Enter unit name (e.g., Piece, Kilogram)"
                                       required />
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
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

                        <!-- Abbreviation -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Abbreviation</span>
                                <span class="label-text-alt text-base-content/60">(Optional)</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="abbreviation"
                                       value="{{ old('abbreviation', $unit->abbreviation) }}"
                                       class="input input-bordered w-full pr-10 @error('abbreviation') input-error @enderror"
                                       placeholder="Enter abbreviation (e.g., pc, kg, L)"
                                       maxlength="10" />
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            @error('abbreviation')
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
                                    <option value="active" {{ old('status', $unit->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $unit->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-base-content/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('units.index') }}"
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
                    Update Unit
                </button>
            </div>
        </form>
    </div>

</x-layouts.app>
