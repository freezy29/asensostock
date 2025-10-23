<div class="tooltip" data-tip="Delete">
    <form method="POST" {{ $attributes }}>
        @csrf
        @method('DELETE')
<button
            type="submit"
            onclick="return confirm('Are you sure you want to delete this user?')"
            class="btn btn-square">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7l1-3h4l1 3" />
            </svg>
        </button>
    </form>
</div>
