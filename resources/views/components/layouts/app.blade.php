<!DOCTYPE html>
<html lang="en" data-theme="light" style="scroll-padding-top: 5rem; scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - AsensoStock' : 'AsensoStock' }}</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body>

    <div class="drawer lg:drawer-open mx-auto pt-16 lg:pt-0">
      <input id="drawer" type="checkbox" class="drawer-toggle" />
      <div class="drawer-content">
        <!-- Page content here -->
        <div class="
        bg-base-100/90 text-base-content fixed lg:sticky top-0 z-30 flex h-16 w-full [transform:translate3d(0,0,0)] justify-center backdrop-blur transition-shadow duration-100 print:hidden
        shadow-xs
        ">
            <x-partials.navbar>
            </x-partials.navbar>
        </div>


        <div class="relative max-w-[100vw] px-6 pb-16 xl:pe-2">
            <main class="prose prose-sm md:prose-base w-full grow pt-10">
                {{ $slot }}
            </main>
        </div>


      </div>

    <x-partials.sidebar>
    </x-partials.sidebar>

    </div>

    </body>
</html>
