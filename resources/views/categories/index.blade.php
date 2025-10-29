<x-layouts.app>
  <x-slot:title>Categories</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Categories</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Categories
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

            @can('create', App\Models\Category::class)
            <x-ui.buttons.create href="{{ route('categories.create') }}">
                Add Category
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <div class="overflow-x-auto m-8">
        <table class="table table-zebra table-lg">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Category Name</th>
                    @if (auth()->user()->role !== 'staff')
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($categories as $category)
                <tr>
                    <td></td>
                    <td>{{ $category->name }}</td>

                    @if (auth()->user()->role !== 'staff')
                    <td>

                    @if(strtolower($category->status) === 'active')
                      <span class="badge badge-success badge-md">Active</span>
                    @else
                      <span class="badge badge-error badge-md">Inactive</span>
                    @endif

                    </td>
                    @endif
                    <td>

                        <x-ui.buttons.view href="{{ route('categories.show', $category->id) }}">
                        </x-ui.buttons.view>

                    @canany(['update', 'delete'], $category)

                        <x-ui.buttons.edit href="{{ route('categories.edit', $category->id) }}">
                        </x-ui.buttons.edit>

                        <x-ui.buttons.delete action="{{ route('categories.destroy', $category->id) }}">
                        </x-ui.buttons.delete>
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="4" class="text-center text-gray-500 py-6">No categories yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</x-layouts.app>
