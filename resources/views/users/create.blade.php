<x-layouts.app>
  <x-slot:title>Create User</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li>Create User</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Create User</h1>
        </div>
    </div>

    <div class="divider"></div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <!-- Personal Information Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">First Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="first_name"
                                       value="{{ old('first_name') }}"
                                       class="input input-bordered w-full @error('first_name') input-error @enderror"
                                       placeholder="Enter first name"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            @error('first_name')
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

                        <!-- Last Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Last Name</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="last_name"
                                       value="{{ old('last_name') }}"
                                       class="input input-bordered w-full @error('last_name') input-error @enderror"
                                       placeholder="Enter last name"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            @error('last_name')
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

            <!-- Contact Information Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-secondary/10 rounded-lg">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Contact Information</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Email Address</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="input input-bordered w-full @error('email') input-error @enderror"
                                       placeholder="user@example.com"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @error('email')
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

                        <!-- Phone -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Phone Number</span>
                                <span class="label-text-alt text-base-content/60">Optional</span>
                            </label>
                            <div class="relative">
                                <input type="tel"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       class="input input-bordered w-full tabular-nums"
                                       placeholder="+63 912 345 6789"
                                       pattern="^(09|\+639)\d{9}$" />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-accent/10 rounded-lg">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Security & Access</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Password -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Password</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                       name="password"
                                       class="input input-bordered w-full @error('password') input-error @enderror"
                                       placeholder="Enter secure password"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Confirm Password</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                       name="password_confirmation"
                                       class="input input-bordered w-full"
                                       placeholder="Confirm your password"
                                       required />
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>

                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror

                        <!-- Role -->
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('users.index') }}"
                   class="btn btn-outline btn-lg flex-1 sm:flex-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary btn-lg flex-1 sm:flex-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4M15,5.9C16.16,5.9 17.1,6.84 17.1,8C17.1,9.16 16.16,10.1 15,10.1A2.1,2.1 0 0,1 12.9,8A2.1,2.1 0 0,1 15,5.9M4,7V10H1V12H4V15H6V12H9V10H6V7H4M15,13C12.33,13 7,14.33 7,17V20H23V17C23,14.33 17.67,13 15,13M15,14.9C17.97,14.9 21.1,16.36 21.1,17V18.1H8.9V17C8.9,16.36 12,14.9 15,14.9Z"></path>
                    </svg>
                    Create User
                </button>
            </div>
        </form>
    </div>

</x-layouts.app>
