<x-layouts.app>
  <x-slot:title>
      Staff Management
  </x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li>Staffs</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                      Staffs
               </x-slot:page_title>

                <form method="GET" action="{{ route('users.index') }}" class="space-y-2">
                    <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input />

                    <div class="form-control">
                        <select name="status" class="select select-bordered w-full" onchange="this.form.submit()">
                            <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    </div>
                </form>



            <x-ui.buttons.create href="{{ route('users.create') }}">
                  Add Staff
            </x-ui.buttons.create>

        </x-partials.header>


        <x-ui.table>
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
              @forelse ($users as $user)
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


                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>

                    <td>
                        <x-ui.buttons.view href="{{ route('users.show', $user->id) }}">
                        </x-ui.buttons.view>

                        <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.view href="{{ route('users.show', $user->id) }}">
                        </x-ui.buttons.view>
                        
                        <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}">
                        </x-ui.buttons.edit>
                    </td>

                </tr>
                  @empty
                <tr>
                  <td colspan="6" class="text-center text-gray-500 py-6">No staffs yet.</td>
                </tr>
                @endforelse
            </tbody>
        </x-ui.table>

    {{ $users->onEachSide(5)->links() }}

</x-layouts.app>
