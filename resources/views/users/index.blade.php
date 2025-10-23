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

            <x-ui.create-button href="{{ route('users.create') }}">
                Create User
            </x-ui.create-button>

        </x-partials.header>

    <div class="divider"></div>

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

                    <div class="tooltip" data-tip="View Details">
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-square">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </a>
                    </div>


                    <div class="tooltip" data-tip="Edit">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-square">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20l4-1 11-11-3-3L6 16l-2 4z" />
                          </svg>
                        </a>
                    </div>

                        <div class="tooltip" data-tip="Delete">
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to delete this user?')"
                                class="btn btn-square">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7l1-3h4l1 3" />
                              </svg>
                            </button>
                            </form>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</x-layouts.app>
