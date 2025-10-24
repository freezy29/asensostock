<x-layouts.app>
  <x-slot:title>User Details</x-slot:title>

        <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li>{{ $user->first_name }} {{ $user->last_name }}</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  User Details
                </x-slot:page_title>

                <div class="flex gap-2">
                    <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                        Edit User
                    </x-ui.buttons.edit>

                    <x-ui.buttons.delete action="{{ route('users.destroy', $user->id) }}">
                        Delete User
                    </x-ui.buttons.delete>
                </div>

        </x-partials.header>

    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- User Profile Header -->
                <div class="flex items-center gap-6 mb-8">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-base-content">{{ $user->first_name }} {{ $user->last_name }}</h1>
                        <p class="text-lg text-base-content/70">{{ $user->email }}</p>
                        <div class="mt-2">
                            @if(strtolower($user->status) === 'active')
                                <span class="badge badge-success badge-lg">Active</span>
                            @else
                                <span class="badge badge-error badge-lg">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- User Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm text-base-content/70">ID</div>
                                <div class="font-medium">{{ $user->id ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">First Name</div>
                                <div class="font-medium">{{ $user->first_name ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Last Name</div>
                                <div class="font-medium">{{ $user->last_name ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Email Address</div>
                                <div class="font-medium">{{ $user->email ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Phone Number</div>
                                <div class="font-medium">{{ $user->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm text-base-content/70">Role</div>
                                <div class="font-medium">
                                    <span class="badge badge-primary">{{ ucfirst($user->role ?? 'Staff') }}</span>
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Status</div>
                                <div class="font-medium">
                                    @if(strtolower($user->status) === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Last Login</div>
                                <div class="font-medium">
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->format('M d, Y g:i A') }}
                                    @else
                                        Never
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Created At</div>
                                <div class="font-medium">
                                    @if($user->created_at)
                                        {{ $user->created_at->format('M d, Y g:i A') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="text-sm text-base-content/70">Last Updated</div>
                                <div class="font-medium">
                                    @if($user->updated_at)
                                        {{ $user->updated_at->format('M d, Y g:i A') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                @if($user->deleted_at)
                    <div class="mt-8 p-4 bg-error/10 border border-error/20 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="font-medium text-error">This user has been deleted</span>
                        </div>
                        <div class="text-sm text-error/70 mt-1">
                            Deleted on {{ $user->deleted_at->format('M d, Y g:i A') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
