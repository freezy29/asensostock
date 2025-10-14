<x-layouts.app>
  <x-slot:title>Products</x-slot:title>

  <div class="product-page">
    {{-- Mobile-only tweaks scoped to this page. These rules apply only on small screens (<=640px)
        and won't change the desktop/tablet layout. --}}
    <style>
      /* Desktop/tablet: prevent stray horizontal scrollbar while preserving layout */
      .product-page { overflow-x: hidden; }
      .product-page .overflow-x-auto { overflow-x: visible; }

      @media (max-width: 640px) {
        /* avoid page-level horizontal scrollbar on phones */
        html, body { overflow-x: hidden; }

        /* Stack the search/input controls and make them full width */
        .product-page form.flex { display: flex !important; flex-direction: column; align-items: stretch; gap: .5rem; }
        .product-page .input-group { width: 100%; display: flex; gap: .5rem; }
        .product-page .input-group .input { flex: 1 1 auto; width: 100%; }
        .product-page .input-group .btn { flex: 0 0 auto; }

        /* Reduce card / table paddings so table fits better on small screens */
        .product-page .card .p-4 { padding: .5rem !important; }
        .product-page table.table th, .product-page table.table td { padding-top: .45rem; padding-bottom: .45rem; }

        /* Allow action buttons to wrap instead of forcing width */
        .product-page .inline-flex { flex-wrap: wrap; gap: .25rem; }

        /* Slightly reduce left/right spacing around main content on phones */
        .product-page .px-6 { padding-left: 1rem !important; padding-right: 1rem !important; }

        /* If a horizontal scrollbar remains from a wide element, make the table scroll internally */
        .product-page .overflow-x-auto { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      }
    </style>

  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-8">
    <div>
      <h1 class="text-4xl sm:text-5xl font-bold">Products</h1>
      <p class="text-base text-gray-500 mt-2">Manage your product catalog and stock levels</p>
    </div>

    {{-- Mobile-only controls: Filter (below description), then Search, then Add Product --}}
    <div class="block sm:hidden mt-4">
      <div class="mb-3 flex items-center">
        <!-- compact filter button (small rectangle) -->
        <button class="btn btn-outline btn-md w-24">Filter</button>
      </div>

      <form method="GET" action="" class="w-full mb-3">
        <div class="input-group w-full">
          <input type="search" name="q" class="input input-bordered input-lg w-full" placeholder="Search products..." aria-label="Search products" />
          <button type="submit" class="btn btn-primary btn-square btn-lg" aria-label="Search" title="Search">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="7"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </button>
        </div>
      </form>

      <div class="flex">
        <!-- compact add button with fixed width to match screenshot -->
        <a href="/products/create" class="btn btn-primary w-44 inline-flex items-center justify-center gap-3 py-2 rounded-md shadow-md" title="Add Product" aria-label="Add Product">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Add Product
        </a>
      </div>
    </div>

  <div class="hidden sm:flex items-center gap-4 w-full sm:w-auto">
      <form method="GET" action="" class="flex items-center gap-3 w-full sm:w-auto">
        <div class="input-group w-full sm:w-auto">
          <input type="search" name="q" class="input input-bordered input-lg w-full sm:w-80" placeholder="Search products..." aria-label="Search products" />
          <div class="tooltip" data-tip="Search">
            <button type="submit" class="btn btn-primary btn-square btn-md" aria-label="Search" title="Search">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </button>
          </div>
        </div>

        <div class="dropdown">
          <div class="tooltip" data-tip="Filter">
            <button tabindex="0" class="btn btn-outline btn-md ml-0 sm:ml-2" title="Filter">Filter</button>
          </div>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-56">
            <li><a>All categories</a></li>
            <li><a>Active</a></li>
            <li><a>Inactive</a></li>
          </ul>
        </div>

        <div class="tooltip" data-tip="Add product">
          <a href="/products/create" class="btn btn-primary ml-2 hidden sm:inline-flex items-center gap-3 btn-md" title="Add product" aria-label="Add product">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Add Product
          </a>
        </div>

        <!-- on very small screens keep a compact Add button -->
        <div class="tooltip" data-tip="Add product">
          <a href="/products/create" class="btn btn-primary ml-2 sm:hidden btn-md" title="Add product" aria-label="Add product">+</a>
        </div>
      </form>
    </div>
  </div>

  <div class="mt-4">
    <div class="overflow-x-auto">
      <div class="card bg-base-100 shadow-sm rounded-lg">
        <div class="p-4">
          <table class="table w-full table-zebra text-sm sm:text-base">
            <thead>
              <tr>
                <th class="w-24 py-3 sm:py-4 text-center">#</th>
                <th class="py-3 sm:py-4">Product Name</th>
                <th class="py-3 sm:py-4">Category</th>
                <th class="py-3 sm:py-4">Status</th>
                <th class="text-center py-3 sm:py-4">Variants</th>
                <th class="text-center py-3 sm:py-4">Total Stocks</th>
                <th class="text-center py-3 sm:py-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                @php
                  $product_variants = $variants->where('product_id', $product->id);
                  $total_stocks = 0;
                  foreach ($product_variants as $variant) {
                    $total_stocks += $variant->current_qty;
                  }
                @endphp
                <tr class="align-middle">
                  <th class="py-3 sm:py-4 text-center">{{ $product->id }}</th>
                  <td class="font-medium py-3 sm:py-4">{{ $product->name }}</td>
                  <td class="py-3 sm:py-4">{{ optional($product->category)->name ?? '-' }}</td>
                  <td class="py-3 sm:py-4">
                    @if(strtolower($product->status) === 'active')
                      <span class="badge badge-success badge-md">Active</span>
                    @else
                      <span class="badge badge-ghost">{{ $product->status }}</span>
                    @endif
                  </td>
                  <td class="text-center py-3 sm:py-4">{{ $product_variants->count() }}</td>
                  <td class="text-center py-3 sm:py-4">{{ $total_stocks }}</td>
                  <td class="text-center py-3 sm:py-4">
                    <div class="inline-flex gap-2 justify-center">
                      <!-- realistic small square action buttons -->
                      <div class="tooltip" data-tip="View">
                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:shadow-md transition" title="View" aria-label="View">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </a>
                      </div>

                      <div class="tooltip" data-tip="Edit">
                        <a href="/products/{{ $product->id }}/edit" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-yellow-50 hover:shadow-md transition" title="Edit" aria-label="Edit">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20l4-1 11-11-3-3L6 16l-2 4z" />
                          </svg>
                        </a>
                      </div>

                      <div class="tooltip" data-tip="Delete">
                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-red-50 hover:shadow-md transition" title="Delete" aria-label="Delete">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7l1-3h4l1 3" />
                          </svg>
                        </a>
                      </div>

                      <div class="tooltip" data-tip="Add variant">
                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white border border-gray-200 shadow-sm hover:bg-primary/10 hover:shadow-md transition" title="Add variant" aria-label="Add variant">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-gray-500 py-6">No products yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</x-layouts.app>
  </div>
