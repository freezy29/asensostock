<x-layouts.app>
  <x-slot:title>Categories</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li>Categories</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  Categories
                </x-slot:page_title>


            <form method="GET" action="{{ route('categories.index') }}" class="space-y-2">
                <div class="flex flex-col md:flex-row gap-2">
                    <x-ui.search-input placeholder="Search categories..." />

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

            @can('create', App\Models\Category::class)
            <x-ui.buttons.create href="{{ route('categories.create') }}">
                Add Category
            </x-ui.buttons.create>
            @endcan

        </x-partials.header>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4 m-4">
        @forelse ($categories as $category)
            <div class="card bg-base-100 shadow-md border border-base-300">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="card-title text-lg">{{ $category->name }}</h3>
                        </div>
                        @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                            @if(strtolower($category->status) === 'active')
                                <span class="badge badge-success badge-md">Active</span>
                            @else
                                <span class="badge badge-error badge-md">Inactive</span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/70">Products:</span>
                            <span class="font-medium">{{ $category->products_count }}</span>
                        </div>
                    </div>

                    <div class="card-actions justify-end mt-4">
                        <x-ui.buttons.view href="{{ route('categories.show', $category->id) }}">
                        </x-ui.buttons.view>
                        @canany(['update', 'delete'], $category)
                            <x-ui.buttons.edit href="{{ route('categories.edit', $category->id) }}">
                            </x-ui.buttons.edit>
                            <x-ui.buttons.delete action="{{ route('categories.destroy', $category->id) }}">
                                <x-slot:onclick>
                                    return confirm('Are you sure you want to delete this category?')
                                </x-slot:onclick>
                            </x-ui.buttons.delete>
                        @endcanany
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                @if(request()->has('search') || request()->has('status'))
                    No categories found matching your filters.
                @else
                    No categories yet.
                @endif
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <x-ui.table class="hidden md:block">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Number of Products</th>
                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($categories as $category)
                <tr>
                    <th>{{ $category->name }}</th>
                    <td>{{ $category->products_count }}</td>

                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
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

                        
                        
                    @endcanany

                    </td>
                </tr>
                  @empty
                <tr>
                  <td colspan="{{ in_array(auth()->user()->role, ['admin', 'super_admin']) ? '4' : '3' }}" class="text-center text-gray-500 py-6">
                    @if(request()->has('search') || request()->has('status'))
                        No categories found matching your filters.
                    @else
                        No categories yet.
                    @endif
                  </td>
                </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{ $categories->onEachSide(5)->links() }}

</x-layouts.app>
