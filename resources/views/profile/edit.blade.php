<x-layouts.app>
  <x-slot:title>Profile</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li><a href="{{ route('profile.show') }}">Profile</a></li>
                      <li>Edit</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                     Edit Profile
               </x-slot:page_title>

            </x-partials.header>

<div class="max-w-3xl">
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="card bg-base-200 border border-base-300">
            <div class="card-body">
                <h3 class="card-title">Personal information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label"><span class="label-text">First name</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.68 0-5.216-.584-7.5-1.632Z" /></svg>
                            <input type="text" name="first_name" class="grow" value="{{ old('first_name', $user->first_name) }}" required />
                        </label>
                        @error('first_name')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text">Last name</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.68 0-5.216-.584-7.5-1.632Z" /></svg>
                            <input type="text" name="last_name" class="grow" value="{{ old('last_name', $user->last_name) }}" required />
                        </label>
                        @error('last_name')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="label"><span class="label-text">Email</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path d="M1.5 8.25l9 5.25 9-5.25M3.75 6h16.5A1.5 1.5 0 0 1 21.75 7.5v9A1.5 1.5 0 0 1 20.25 18H3.75A1.5 1.5 0 0 1 2.25 16.5v-9A1.5 1.5 0 0 1 3.75 6Z"/></svg>
                            <input type="email" name="email" class="grow" value="{{ old('email', $user->email) }}" required />
                        </label>
                        @error('email')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text">Phone</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path d="M2.25 4.5A2.25 2.25 0 0 1 4.5 2.25h3A2.25 2.25 0 0 1 9.75 4.5v15A2.25 2.25 0 0 1 7.5 21.75h-3A2.25 2.25 0 0 1 2.25 19.5v-15Z"/><path d="M6 18.75h.008v.008H6v-.008Z"/></svg>
                            <input type="text" name="phone" class="grow" value="{{ old('phone', $user->phone) }}" />
                        </label>
                        @error('phone')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div id="password" class="card bg-base-200 border border-base-300">
            <div class="card-body">
                <h3 class="card-title">Change password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label"><span class="label-text">New password</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path fill-rule="evenodd" d="M12 1.5A5.25 5.25 0 0 0 6.75 6.75V9h-.75A2.25 2.25 0 0 0 3.75 11.25v8.25A2.25 2.25 0 0 0 6 21.75h12a2.25 2.25 0 0 0 2.25-2.25v-8.25A2.25 2.25 0 0 0 18.75 9h-.75V6.75A5.25 5.25 0 0 0 12 1.5Zm-3 7.5V6.75a3 3 0 1 1 6 0V9H9Z" clip-rule="evenodd"/></svg>
                            <input type="password" name="password" class="grow" />
                        </label>
                        @error('password')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text">Confirm new password</span></label>
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 opacity-70"><path fill-rule="evenodd" d="M12 1.5A5.25 5.25 0 0 0 6.75 6.75V9h-.75A2.25 2.25 0 0 0 3.75 11.25v8.25A2.25 2.25 0 0 0 6 21.75h12a2.25 2.25 0 0 0 2.25-2.25v-8.25A2.25 2.25 0 0 0 18.75 9h-.75V6.75A5.25 5.25 0 0 0 12 1.5Zm-3 7.5V6.75a3 3 0 1 1 6 0V9H9Z" clip-rule="evenodd"/></svg>
                            <input type="password" name="password_confirmation" class="grow" />
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('profile.show') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

</x-layouts.app>
