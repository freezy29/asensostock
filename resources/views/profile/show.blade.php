<x-layouts.app>
  <x-slot:title>Profile</x-slot:title>

            <x-partials.header>

                <x-slot:breadcrumb_list>
                      <li>Profile</li>
                </x-slot:breadcrumb_list>

                <x-slot:page_title>
                     Profile
               </x-slot:page_title>

            </x-partials.header>

        <h1 class="text-4xl font-bold mb-2">{{ $user->first_name . $user->last_name }}</h1>
</x-layouts.app>
