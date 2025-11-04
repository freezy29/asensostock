<div class="flex flex-col md:flex-row w-full md:justify-between md:items-end flex-wrap">
    <div>
        <div class="breadcrumbs text-md">
          <ul>
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                {{ $breadcrumb_list }}
            </ul>
        </div>
        <h1 class="text-4xl font-bold ">{{ $page_title }}</h1>
    </div>

    <div class="flex gap-2 mt-4 md:mt-0 flex-col md:flex-row flex-wrap">
        {{ $slot }}
    </div>
</div>

<div class="divider -mt-0.2"></div>
