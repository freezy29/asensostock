<!DOCTYPE html>
<html lang="en" data-theme="lofi">
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
    <body class="min-h-screen flex flex-col bg-base-200 font-sans">
        <div class="navbar bg-base-100 shadow-sm">
          <div class="flex-none">
            <button class="btn btn-square btn-ghost">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path> </svg>
            </button>
          </div>
          <div class="flex-1">
            <a href="/" class="btn btn-ghost text-xl">AsensoStock</a>
          </div>
          <div class="flex-none">
            <div class="dropdown dropdown-end">
              <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="indicator">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /> </svg>
                  <span class="badge badge-sm indicator-item">8</span>
                </div>
              </div>
              <div
                tabindex="0"
                class="card card-compact dropdown-content bg-base-100 z-1 mt-3 w-52 shadow">
                <div class="card-body">
                  <span class="text-lg font-bold">8 Items</span>
                  <span class="text-info">Subtotal: $999</span>
                  <div class="card-actions">
                    <button class="btn btn-primary btn-block">View cart</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    <main class="flex-1 container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="footer sm:footer-horizontal footer-center bg-base-300 text-base-content p-4">
      <aside>
        <p>Copyright © {{ date('Y') }} - All right reserved by MCA General Merchandising</p>
      </aside>
    </footer>

    </body>
</html>
