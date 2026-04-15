<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
