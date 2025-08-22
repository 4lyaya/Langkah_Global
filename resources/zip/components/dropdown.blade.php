<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="{{ $triggerClass ?? 'flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white' }}">
        {{ $trigger }}
    </button>

    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 {{ $dropdownClass ?? '' }}">
        {{ $content }}
    </div>
</div>
