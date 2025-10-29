<div class="drawer-side z-40">
<label for="drawer" aria-label="close sidebar" class="drawer-overlay"></label>
<aside class="bg-base-200 text-base-content min-h-screen w-80 flex flex-col">
   <div class="navbar sticky bg-primary text-primary-content top-0 z-30 py-0 px-4 items-center flex">

        <div class="hidden lg:flex item-center">
            <a class="flex shrink-0 items-center justify-center gap-2 text-xl" href="/" aria-current="page aria-label="AsensoStock">
             <img src="{{ asset('images/AsensoStock.svg') }}" class="w-10 rounded-full">
                AsensoStock
            </a>
        </div>

    </div>

    <ul class="flex-1 menu menu-xl w-full px-4 py-6 ">
      <li><a href="{{ route('dashboard.index') }}">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 -960 960 960"
          fill="currentColor"
          class="w-6 h-6 text-base-content"
        >
          <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/>
        </svg>
            Dashboard
        </a></li>
      <li>
            <h2 class="menu-title flex gap-2 text-xl -ml-1">
                    <span class="text-base-content">
                        <svg class="w-6 h-6 text-base-content mt-0.5" xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960"  fill="currentColor">
                            <path d="M620-163 450-333l56-56 114 114 226-226 56 56-282 282Zm220-397h-80v-200h-80v120H280v-120h-80v560h240v80H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v200ZM480-760q17 0 28.5-11.5T520-800q0-17-11.5-28.5T480-840q-17 0-28.5 11.5T440-800q0 17 11.5 28.5T480-760Z"/>
                        </svg>
                    </span>
                    Inventory
            </h2>
            <ul class="ml-8">
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li><a href="{{ route('units.index') }}">Units</a></li>
            </ul>
        </li>
                <li> <a href="/transactions">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-base-content"></title><path d="M21,9L17,5V8H10V10H17V13M7,11L3,15L7,19V16H14V14H7V11Z" /></svg>
             Transactions</a></li>

            @if (auth()->user()->role !== 'staff')
          <li>
            <a href="{{ route('users.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor" class="w-6 h-6 text-base-content">
                <path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z"/>
                    </svg>
                    @if (auth()->user()->role === 'super_admin')
               Users
                    @elseif (auth()->user()->role === 'admin')
                Staffs
                    @endif
        </a>
        </li>
            @endif
    </ul>

</aside>
</div>
