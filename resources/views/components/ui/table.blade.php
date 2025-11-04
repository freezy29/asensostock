@php
    $class = $attributes->get('class', '');
    $classes = explode(' ', $class);
    $visibilityClasses = [];
    $otherClasses = [];
    
    foreach ($classes as $cls) {
        if (str_contains($cls, 'hidden') || str_starts_with($cls, 'md:') || str_starts_with($cls, 'lg:') || str_starts_with($cls, 'sm:')) {
            $visibilityClasses[] = $cls;
        } elseif (!empty($cls)) {
            $otherClasses[] = $cls;
        }
    }
    
    $wrapperClasses = 'overflow-x-auto m-8 ' . implode(' ', $visibilityClasses);
    $tableClasses = 'table table-zebra ' . implode(' ', $otherClasses);
@endphp
<div class="{{ trim($wrapperClasses) }}">
	<table class="{{ trim($tableClasses) }}">
		{{ $slot }}
	</table>
</div>


