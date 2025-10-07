<x-layout>
    <x-slot:title>
     Product Details
    </x-slot:title>

        <h1 class="text-5xl font-bold">Product details</h1>

    <form>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Product name</legend>
            <input type="text" class="input" value="{{ $product->name }}" />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Category</legend>
            <select class="select">
                <option>{{ $product->category->name }}</option>
            </select>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status</legend>
            <input type="checkbox" checked="checked" class="toggle" />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Created Date</legend>
            <input type="datetime-local" class="input" value="{{ $product->created_at }}" />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Updated Date</legend>
            <input type="datetime-local" class="input" value="{{ $product->updated_at }}" />
        </fieldset>
    </form>


    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Variant Type</th>
                    <th>Measure Value</th>
                    <th>Measure Unit</th>
                    <th>Conversion Rate</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Critical Level</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($variants as $variant)
                <tr>
                    <th>{{ $variant->type->name }}</th>
                    <td>{{ (int)$variant->measure_value }}</td>
                    <td>{{ $variant->unit->name }}</td>
                    <td>{{ $variant->conversion_rate }}</td>
                    <td>₱{{ $variant->price }}</td>
                    <td>{{ $variant->current_qty }}</td>
                    <td>{{ $variant->critical_level }}</td>
                    <td>{{ $variant->updated_at}}</td>
                    <td>
                        <a href="" class="btn">✏</a>
                        <a href="" class="btn">🔄</a>
                        <a href="" class="btn">🗑</a>
                    </td>
                </tr>
               @empty
                <p class="text-gray-500">No variants??</p>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout>

