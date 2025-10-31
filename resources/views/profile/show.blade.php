<x-layouts.app>
  <x-slot:title>Profile</x-slot:title>

<div class="flex flex-col md:flex-row w-full md:justify-between md:items-end">
    <div>
        <h1 class="text-4xl font-bold mb-2">Profile</h1>
    </div>

    <div class="flex gap-2">
    </div>
</div>


<div class="divider"></div>

        <h1 class="text-4xl font-bold mb-2">{{ $user->first_name }}</h1>
</x-layouts.app>
