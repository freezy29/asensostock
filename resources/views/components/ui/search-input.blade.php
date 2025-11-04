@props([
    'name' => 'search',
    'placeholder' => 'Search',
    'value' => null,
    'buttonText' => 'Search',
])

<div class="join w-full md:flex-1 md:min-w-0">
    <label class="input join-item flex-1 min-w-0">
        <svg class="h-[1em] opacity-50 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
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
        <input
            type="search"
            name="{{ $name }}"
            value="{{ $value ?? request($name) }}"
            placeholder="{{ $placeholder }}"
            class="min-w-14 flex-1"
            {{ $attributes->except(['name', 'placeholder', 'value', 'buttonText', 'class']) }}
        />
    </label>

    <button class="btn btn-primary join-item flex-shrink-0" type="submit" aria-label="{{ $buttonText }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </button>
</div>
