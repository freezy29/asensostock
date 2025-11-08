<nav class="navbar w-full py-0 bg-primary text-primary-content px-4 ">
  <div class="navbar-start flex flex-1 item-center gap-2 ">
    <div class="lg:hidden">
        <label for="drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="inline-block h-6 w-6 stroke-current"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>

          </svg>
        </label>
      </div>
    <a class="lg:hidden me-2 flex w-35  shrink-0 items-center text-xl" href="/" aria-current="page aria-label="AsensoStock">
     <img src="{{ asset('images/AscensoNoBG.svg') }}" class="w-16 rounded-full font-bold ">
        <span class='font-bold'>  AsensoStock </span>
    </a>
  </div>
  <div class="navbar-end flex-none gap-2 text-primary-content">

     <div class="dropdown dropdown-end ">
       <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
         <div class="indicator">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
           </svg>
           @if($lowStockCount > 0)
             <span class="badge badge-xs badge-success indicator-item">{{ $lowStockCount > 9 ? '9+' : $lowStockCount }}</span>
           @endif
         </div>
       </div>
       <div tabindex="-1" class="dropdown-content z-50 mt-3 w-72 sm:w-80 md:w-96 max-w-[90vw] max-h-[60vh] overflow-auto rounded-box bg-base-100 text-base-content shadow-xl">
         <div class="p-4 border-b border-base-300">
           <p class="font-semibold">{{ $lowStockCount }} stock {{ $lowStockCount === 1 ? 'alert' : 'alerts' }}</p>
         </div>
         <ul class="p-0">
           @forelse($lowStockItems as $item)
             @php
               $isCritical = $item->stock_quantity <= $item->critical_level;
               $dotClass = $isCritical ? 'bg-error' : 'bg-warning';
             @endphp
             <li class="px-0">
               <a href="{{ route('products.show', $item->id) }}" class="px-3 sm:px-4 py-3 block hover:bg-base-200">
                 <div class="flex items-start gap-3">
                   <span class="mt-1 inline-block h-3 w-3 rounded-full {{ $dotClass }}"></span>
                   <div class="min-w-0">
                     <p class="text-sm leading-snug">
                       <span class="font-medium">{{ $item->name }}</span>
                       @if($isCritical)
                         is critical
                       @else
                         is low
                       @endif
                     </p>
                     <p class="text-xs opacity-70">Qty: {{ $item->stock_quantity }} • Critical: {{ $item->critical_level }} • {{ optional($item->updated_at)->diffForHumans() }}</p>
                   </div>
                 </div>
               </a>
             </li>
           @empty
             <li class="px-4 py-4 text-sm opacity-70">No low stock alerts</li>
           @endforelse
         </ul>
         @if($lowStockCount > 0)
         <div class="p-3 text-right border-t border-base-300">
           <a href="{{ route('products.index', ['stock_status' => $viewAllStatus, 'status' => 'active']) }}" class="btn btn-ghost btn-sm">View all</a>
         </div>
         @endif
       </div>
     </div>

        <label class="swap swap-rotate">
            <!-- this hidden checkbox controls the state -->
            <input type="checkbox" class="theme-controller" id="theme-toggle" value="dark" />

            <!-- sun icon -->
            <svg
                class="swap-off h-10 w-10 fill-current"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path
                    d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
            </svg>

            <!-- moon icon -->
            <svg
                class="swap-on h-10 w-10 fill-current"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path
                    d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
            </svg>
        </label>

    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="md:pr-4 btn btn-ghost btn-circle md:btn-wide">
        <div class="avatar">
            <div class="w-10 rounded-full">
              <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . " " . auth()->user()->last_name) }}&background=random" />
            </div>
        </div>
     @auth
    <div class="hidden md:block">
        <p class="font-bold text-sm"> {{ auth()->user()->first_name . " " . auth()->user()->last_name }} </p>
        <p class="text-xs text-start w-full">{{ (auth()->user()->role === 'super_admin') ? 'Super Admin' :ucfirst(auth()->user()->role) }}</p>
    </div>
    @endauth
      </div>
      <ul
        tabindex="-1"
        class="menu menu-lg dropdown-content bg-base-100 text-base-content rounded-box z-50 mt-3 w-56 p-2 shadow-lg">
         @auth
            <li class="md:hidden">
              <a class="flex items-center gap-3 px-2 py-2" href="{{ route('profile.show') }}">
                <div class="avatar">
                  <div class="w-8 rounded-full">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name . " " . auth()->user()->last_name) }}&background=random" />
                  </div>
                </div>
                <div class="min-w-0">
                  <p class="font-semibold text-sm leading-tight truncate">{{ auth()->user()->first_name . " " .  auth()->user()->last_name }}</p>
                  <p class="text-xs opacity-70">{{ (auth()->user()->role === 'super_admin') ? 'Super Admin' : ucfirst(auth()->user()->role) }}</p>
                </div>
              </a>
            </li>
         @endauth

            <li class="hidden md:block"><a href="{{ route('profile.show') }}">Profile</a></li>
            <div class="divider -my-1"></div>
              <form method="POST" action="/logout" class="inline">
                @csrf
            <li>
                <button type="submit" class="text-error hover:bg-error/10">Logout</button>
            </li>
              </form>
      </ul>
    </div>

    </div>

</nav>
