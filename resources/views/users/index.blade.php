<x-layouts.app>
  <x-slot:title>
      Users
  </x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li>Users</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                      User Management
               </x-slot:page_title>



                <label class="input">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g
                            stroke-linejoin="round"
                            stroke-linecap="round"
                            stroke-width="2.5"
                            fill="none"
                            stroke="currentColor"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" required placeholder="Search" />
                </label>

            <div class="dropdown">
              <div tabindex="0" role="button" class="btn ">Status</div>
              <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li><a>All</a></li>
                <li><a>Active</a></li>
                <li><a>Inactive</a></li>
              </ul>
            </div>


            <div class="dropdown">
              <div tabindex="0" role="button" class="btn ">Role</div>
              <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li><a>All</a></li>
                <li><a>Admin</a></li>
                <li><a>Staff</a></li>
              </ul>
            </div>

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
