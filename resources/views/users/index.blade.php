<x-layouts.app>
  <x-slot:title>
      Users
  </x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li>Users</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                      Users
               </x-slot:page_title>

                <form method="GET" action="{{ route('users.index') }}" class="space-y-2">
                    <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input/>

                    <div class="flex justify-between gap-2">
                        <div class="form-control flex-1">
                            <select name="status" class="select select-bordered w-full min-w-26" onchange="this.form.submit()">
                                <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="form-control flex-1">
                            <select name="role" class="select select-bordered w-full min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('role') === '' ? 'selected' : '' }}>All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                    </div>

                    </div>
                </form>

            <x-ui.buttons.create href="{{ route('users.create') }}">
                  Create User
            </x-ui.buttons.create>

        </x-partials.header>


        <x-ui.table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($users as $user)
                <tr>
                    <th>{{ $user->first_name . " " .  $user->last_name }}</th>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td>
                        @if(strtolower($user->status) === 'active')
                          <span class="badge badge-success badge-md">Active</span>
                        @else
                          <span class="badge badge-error badge-md">Inactive</span>
                        @endif
                    </td>

                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>

                    <td>
                        <x-ui.buttons.view href="{{ route('users.show', $user->id) }}">
                        </x-ui.buttons.view>

                        <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                        </x-ui.buttons.edit>

                        @can('delete', $user)
                        <x-ui.buttons.delete action="{{ route('users.destroy', $user->id) }}">
                            <x-slot:onclick>
                                return confirm('Are you sure you want to delete this user?')
                            </x-slot:onclick>

                        </x-ui.buttons.delete>
                        @endcan
                    </td>

                </tr>
                  @empty
                <tr>
                  <td colspan="7" class="text-center text-gray-500 py-6">No yet.</td>
                </tr>
                @endforelse
            </tbody>
        </x-ui.table>

    {{ $users->onEachSide(5)->links() }}

</x-layouts.app>
