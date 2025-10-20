<x-layouts.app>
  <x-slot:title>Edit User Details</x-slot:title>

    <form method="POST" action="{{ route('users.update', $user->id ) }}">
        @csrf
        @method('PUT')
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xl border p-4">
            <legend class="fieldset-legend">edit user details</legend>

            <label class="label">First Name</label>
            <input type="text" name="first_name"
            value="{{ old('first_name', $user->first_name) }}"
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
            value="{{ old('last_name', $user->last_name) }}"
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
            value="{{ old('email', $user->email) }}"
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
                value="{{ old('phone', $user->phone) }}"
                name="phone"
                placeholder="Phone (optional)"
                pattern="^(09|\+639)\d{9}$"
              />
            </label>

            <label class="label">Password</label>
            <input type="password" name="password" class="input"
            placeholder="Password"
            />

            <label class="label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="input"
            placeholder="Password"/>

            @error('password')
               <div class="label mb-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
               </div>
            @enderror

            <label class="label">Role</label>
            <select name="role" class="select validator" required>
                @if ($user->role === 'admin')
                    <option value="admin" selected>Admin</option>
                    <option value="staff">Staff</option>
                @elseif ($user->role === 'staff')
                    <option value="admin">Admin</option>
                    <option value="staff" selected>Staff</option>
                @endif
            </select>

            <label class="label">Status</label>
            <label class="label">
            <input type="checkbox"
                @if ($user->status === 'active')
                checked="checked"
                @endif
                name="status"
                class="toggle" />
                Active </label>

            <button type="submit" class="btn btn-neutral mt-4">edit user</button>
        </fieldset>
    </form>

    @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


</x-layouts.app>

