<x-layouts.app>
  <x-slot:title>User Details</x-slot:title>

        <x-partials.header>

                <x-slot:breadcrumb_list>
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li>User Details</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                  User Details
                </x-slot:page_title>


        </x-partials.header>

</x-layouts.app>
