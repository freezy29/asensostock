<div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
    <div>
        @isset($breadcrumb_list)
        <div class="breadcrumbs text-md text-wrap">
          <ul>
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                {{ $breadcrumb_list }}
            </ul>
        </div>
        @endisset
        <h1 class="text-4xl font-bold ">{{ $page_title }}</h1>
    </div>

    <div class="flex gap-2 mt-4 md:mt-0 flex-col md:flex-row flex-wrap">
        {{ $slot }}
    </div>
</div>

<div class="divider -mt-0.2"></div>
