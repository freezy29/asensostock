<x-layouts.app>
  <x-slot:title>Profile</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li>Profile</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                     My Profile
               </x-slot:page_title>

            </x-partials.header>

        <div class="flex flex-col gap-6">
	            <div class="card bg-gradient-to-r from-primary/10 to-secondary/10 border border-base-300">
	                <div class="card-body">
	                    <div class="flex items-center gap-6">
	                        <div class="avatar">
                                <div class="rounded-full">
                                  <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . " " . auth()->user()->last_name) }}&background=random" />
                                </div>
	                        </div>
	                        <div class="flex-1 min-w-0 flex flex-col gap-2">
                                <div class="block md:flex items-center gap-4">
                                    <h2 class="text-3xl font-bold">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                    <div class="badge badge-outline">{{ (auth()->user()->role === 'super_admin') ? 'Super Admin' :ucfirst(auth()->user()->role) }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row flex-1 md:items-center gap-2">
                                    <span>{{ $user->email }}</span>
                                    <span class="hidden md:block">•</span>
                                    <span>Last login: {{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : '—' }}</span>
                                </div>
	                            <a href="{{ route('profile.edit') }}" class="btn btn-primary md:hidden">Edit Profile</a>
	                        </div>
                            <div class="hidden md:block">
	                            <a href="{{ route('profile.edit') }}" class="btn btn-primary ">Edit Profile</a>
                            </div>
	                    </div>
	                </div>
	            </div>

	                <div class="card bg-base-200 border border-base-300">
                    <div class="card-body">
                            <h3 class="card-title lg:text-3xl text-xl -mb-2">Account details</h3>
	                        <div class="mt-4 grid grid-cols-2 gap-x-8 gap-y-3">
                            <div class="text-base-content/70 font-bold">First name</div>
                            <div>{{ $user->first_name }}</div>

                            <div class="text-sm text-base-content/70 font-bold">Last name</div>
                            <div>{{ $user->last_name }}</div>

                            <div class="text-base-content/70 font-bold">Email</div>
                            <div>{{ $user->email }}</div>

                            <div class=" text-base-content/70 font-bold">Phone</div>
                            <div>{{ $user->phone ?? '—' }}</div>

                            <div class=" text-base-content/70 font-bold">Role</div>
                            <div>{{ (auth()->user()->role === 'super_admin') ? 'Super Admin' :ucfirst(auth()->user()->role) }}</div>

                            <div class="text-base-content/70 font-bold">Member since</div>
                            <div>{{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}</div>
                        </div>
                    </div>
                </div>

            </div>

</x-layouts.app>
