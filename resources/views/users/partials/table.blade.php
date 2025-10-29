<table class="table table-zebra table-lg">
    <thead>
        <tr>
            <th></th>
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
        @forelse ($users as $user)
        <tr>
            <td></td>
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
                <x-ui.buttons.view href="{{ route('users.show', $user->id) }}"></x-ui.buttons.view>
                <x-ui.buttons.edit href="{{ route('users.edit', $user->id) }}"></x-ui.buttons.edit>
                @can('delete', $user)
                <x-ui.buttons.delete action="{{ route('users.destroy', $user->id) }}"></x-ui.buttons.delete>
                @endcan
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center py-8 text-base-content/60">No users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

