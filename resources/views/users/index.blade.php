<x-layouts.app>
  <x-slot:title>Users</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Users</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                    Users
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
                <li><a>Active</a></li>
                <li><a>Inactive</a></li>
              </ul>
            </div>

            <x-ui.buttons.create href="{{ route('users.create') }}">
                Create User
            </x-ui.buttons.create>

        </x-partials.header>


    <div class="hidden lg:block overflow-x-auto m-8">
        <table class="table table-zebra table-lg">
            <!-- head -->
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
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
                    <td>{{ $user->last_login_at ? $user->last_login_at->toDateTimeString() : 'Never' }}</td>

                    <td>

                <x-ui.buttons.view href="{{ route('users.show', $user->id) }}">
                </x-ui.buttons.view>

                <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                </x-ui.buttons.edit>

                <x-ui.buttons.delete action="{{ route('users.destroy', $user->id) }}">
                </x-ui.buttons.delete>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</x-layouts.app>
