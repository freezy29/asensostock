<x-layouts.app>
  <x-slot:title>Units</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Units</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Units
                </x-slot:page_title>


            <form method="GET" action="{{ route('units.index') }}" class="space-y-2">
                <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input placeholder="Search units..." />

                    <div class="flex justify-between gap-2">
                        <!-- Status Filter -->
                        <div class="form-control flex-1">
                            <select name="status" class="select select-bordered w-full min-w-24" onchange="this.form.submit()">
                                <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            @can('create', App\Models\Unit::class)
            <x-ui.buttons.create href="{{ route('units.create') }}">
                Add Unit
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <x-ui.table>
            <thead>
                <tr>
                    <th>Unit Name</th>
                    <th>Abbreviation</th>
                    <th>Number of Products</th>
                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($units as $unit)
                <tr>
                    <th>{{ $unit->name }}</th>
                    <td>{{ $unit->abbreviation ?? 'N/A' }}</td>
                    <td>{{ $unit->products_count }}</td>

                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <td>
                        @if(strtolower($unit->status) === 'active')
                          <span class="badge badge-success badge-md">Active</span>
                        @else
                          <span class="badge badge-error badge-md">Inactive</span>
                        @endif
                    </td>
                    @endif
                    <td>

                        <x-ui.buttons.view href="{{ route('units.show', $unit->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $unit)

                        <x-ui.buttons.edit href="{{ route('units.edit', $unit->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.delete action="{{ route('units.destroy', $unit->id) }}">
                            <x-slot:onclick>
                                return confirm('Are you sure you want to delete this unit?')
                            </x-slot:onclick>
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="{{ in_array(auth()->user()->role, ['admin', 'super_admin']) ? '5' : '4' }}" class="text-center text-gray-500 py-6">
                    @if(request()->has('search') || request()->has('status'))
                        No units found matching your filters.
                    @else
                        No units yet.
                    @endif
                  </td>
                </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{ $units->onEachSide(5)->links() }}

</x-layouts.app>
