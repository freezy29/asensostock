<x-layouts.app>
  <x-slot:title>
    @if(auth()->user() && auth()->user()->role === 'admin')
      Staff Management
    @else
      Users
    @endif
  </x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    @if(auth()->user() && auth()->user()->role === 'admin')
                      <li>Staffs</li>
                    @else
                      <li>Users</li>
                    @endif
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                    @if(auth()->user() && auth()->user()->role === 'admin')
                      Staff Management
                    @else
                      User Management
                    @endif
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


            @if (auth()->user()->role === 'super_admin')
            <div class="dropdown">
              <div tabindex="0" role="button" class="btn ">Role</div>
              <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li><a>All</a></li>
                <li><a>Admin</a></li>
                <li><a>Staff</a></li>
              </ul>
            </div>
            @endif

            <x-ui.buttons.create href="{{ route('users.create') }}">
                @if(auth()->user() && auth()->user()->role === 'admin')
                  Add Staff
                @else
                  Create User
                @endif
            </x-ui.buttons.create>

        </x-partials.header>


    <div class="overflow-x-auto m-8">
        <table class="table table-zebra ">
            <!-- head -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    @if (auth()->user()->role === 'super_admin')
                    <th>Role</th>
                    @endif
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name . " " .  $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td>
                        @if(strtolower($user->status) === 'active')
                          <span class="badge badge-success badge-md">Active</span>
                        @else
                          <span class="badge badge-error badge-md">Inactive</span>
                        @endif
                    </td>

                    @if (auth()->user()->role === 'super_admin')
                    <td>{{ ucfirst($user->role) }}</td>
                    @endif

                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>

                    <td>

                <x-ui.buttons.view href="{{ route('users.show', $user->id) }}">
                </x-ui.buttons.view>

                <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                </x-ui.buttons.edit>


                @can('delete', App\Models\User::class)
                <x-ui.buttons.delete action="{{ route('users.destroy', $user->id) }}">
                </x-ui.buttons.delete>
                @endcan

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        {{ $users->onEachSide(5)->links() }}



</x-layouts.app>
