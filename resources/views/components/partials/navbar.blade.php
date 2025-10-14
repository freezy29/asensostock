<nav class="navbar w-full py-0 bg-primary text-primary-content px-4 lg:bg-base-300 lg:text-base-content">
  <div class="navbar-start flex flex-1 item-center gap-2">
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
    <a class="lg:hidden me-2 flex w-35 shrink-0 items-center gap-2 text-xl" href="/" aria-current="page aria-label="AsensoStock">
     <img src="{{ asset('images/AsensoStock.svg') }}" class="w-10 rounded-full">
        AsensoStock
    </a>
  </div>
  <div class="navbar-end flex-none">
    <div class="hidden lg:block dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
            alt="Tailwind CSS Navbar component"
            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
        </div>
      </div>
      <ul
        tabindex="-1"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
</nav>
