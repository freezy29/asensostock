<x-layouts.app>
  <x-slot:title>Create User</x-slot:title>

    <div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
        <div>
            <x-ui.breadcrumbs>
                <li><a>Dashboard</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li>Add User</li>
            </x-ui.breadcrumbs>
            <h1 class="text-4xl font-bold mb-2">Add a User</h1>
        </div>
    </div>

    <div class="divider"></div>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xl border p-4">
            <legend class="fieldset-legend">add a user</legend>

            <label class="label">First Name</label>
            <input type="text" name="first_name"
            value="{{ old('first_name') }}"
            class="input validator @error('first_name') input-error @enderror"
            placeholder="First Name"
            required />
            @error('first_name')
                <div class="label mb-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror

            <label class="label">Last Name</label>
            <input type="text" name="last_name"
            value="{{ old('last_name') }}"
            class="input validator @error('last_name') input-error @enderror"
            placeholder="Last Name" required/>
            @error('last_name')
                <div class="label mb-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror

            <label class="label">Email</label>
            <label class="input validator @error('email') input-error @enderror">
            <input type="email" name="email"
            placeholder="mail@site.com" required
            value="{{ old('email') }}"
            />
            </label>
            @error('email')
               <div class="label mb-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
               </div>
            @enderror

            <label class="label">Phone</label>
            <label class="input validator">
              <input
                type="tel"
                class="tabular-nums"
                value="{{ old('phone') }}"
                name="phone"
                placeholder="Phone (optional)"
                pattern="^(09|\+639)\d{9}$"
              />
            </label>

            <label class="label">Password</label>
            <input type="password" name="password" class="input" placeholder="Password" required/>

            <label class="label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="input" placeholder="Password" required/>

            @error('password')
               <div class="label mb-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
               </div>
            @enderror

            <label class="label">Role</label>
            <select name="role" class="select validator" required>
                <option disabled selected>Role</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>

            <button type="submit" class="btn btn-neutral mt-4">add user</button>
        </fieldset>
    </form>


</x-layouts.app>
