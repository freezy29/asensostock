<div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
    <div>
        <div class="breadcrumbs text-md">
          <ul>
                <li><a>Dashboard</a></li>
                {{ $breadcrumb_list }}
            </ul>
        </div>
        <h1 class="text-4xl font-bold mb-2">{{ $page_title }}</h1>
    </div>

    <div class="flex gap-2">
        {{ $slot }}
    </div>
</div>
