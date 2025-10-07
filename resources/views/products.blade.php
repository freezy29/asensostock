<x-layout>
    <x-slot:title>
      Products
    </x-slot:title>

    <h1 class="text-5xl font-bold">Products</h1>

    <div>
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
            <div tabindex="0" role="button" class="btn m-1">filter ewan</div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li><a>Item 1</a></li>
                <li><a>Item 2</a></li>
            </ul>
        </div>

        <button class="btn mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>          Add Product
        </button>


        <div>

    <div class="mt-8 overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
      <table class="table">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Total Variants</th>
            <th>Total Stocks</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)

          <tr>
            <th>{{ $product->id }}</th>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $variants->where('product_id', $product->id)->count() }}</td>
            @php
                $product_variants = $variants->where('product_id', $product->id);
                $total_stocks = 0;

                foreach ($product_variants as $variant) {
                    $total_stocks += $variant->current_qty;
                }
            @endphp

            <td>{{ $total_stocks }}</td>
            <td>
                <a href="" class="btn">👁</a>
                <a href="/products/{{ $product->id }}/edit" class="btn">✏</a>
                <a href="" class="btn">🗑</a>
                <a href="" class="btn">➕</a>
            </td>
          </tr>
           @empty
            <p class="text-gray-500">No products yet.</p>
            @endforelse
        </tbody>
      </table>
    </div>

</x-layout>
