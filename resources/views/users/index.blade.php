<x-layouts.app>
  <x-slot:title>
    @if(auth()->user() && auth()->user()->role === 'admin')
      Staff Management
    @else
      Users
    @endif
  </x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                    @if(auth()->user() && auth()->user()->role === 'admin')
                      <li>Staffs</li>
                    @else
                      <li>Users</li>
                    @endif
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                    @if(auth()->user() && auth()->user()->role === 'admin')
                      Staff Management
                    @else
                      User Management
                    @endif
                </x-slot:page_title>


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
                <input id="users-search" type="search" placeholder="Search name, email, phone" />
            </label>

            <div class="flex gap-2 items-center">
              <select id="users-status" class="select select-bordered">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              @if(auth()->user() && auth()->user()->role === 'super_admin')
              <select id="users-role" class="select select-bordered">
                <option value="">All Roles</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
              </select>
              @endif
            </div>

            <x-ui.buttons.create href="{{ route('users.create') }}">
                @if(auth()->user() && auth()->user()->role === 'admin')
                  Add Staff
                @else
                  Create User
                @endif
            </x-ui.buttons.create>

        </x-partials.header>


    <div id="users-table-wrapper" class="overflow-x-auto m-8">
        @include('users.partials.table', ['users' => $users])
    </div>

    <script>
      (function(){
        const $q = document.getElementById('users-search');
        const $status = document.getElementById('users-status');
        const $role = document.getElementById('users-role');
        const $wrap = document.getElementById('users-table-wrapper');
        let t;
        function buildUrl(){
          const url = new URL('{{ route('users.search') }}', window.location.origin);
          const params = new URLSearchParams();
          if ($q && $q.value.trim() !== '') params.set('q', $q.value.trim());
          if ($status && $status.value) params.set('status', $status.value);
          if ($role && $role.value) params.set('role', $role.value);
          url.search = params.toString();
          return url.toString();
        }
        async function fetchAndRender(){
          const url = buildUrl();
          $wrap.classList.add('opacity-60');
          try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html,application/json' } });
            const contentType = res.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
              const data = await res.json();
              $wrap.innerHTML = data.html;
            } else {
              const html = await res.text();
              $wrap.innerHTML = html;
            }
          } catch (e) {
            console.error(e);
          } finally {
            $wrap.classList.remove('opacity-60');
          }
        }
        function onChange(){
          clearTimeout(t);
          t = setTimeout(fetchAndRender, 250);
        }
        if ($q) $q.addEventListener('input', onChange);
        if ($status) $status.addEventListener('change', onChange);
        if ($role) $role.addEventListener('change', onChange);
      })();
    </script>



</x-layouts.app>
