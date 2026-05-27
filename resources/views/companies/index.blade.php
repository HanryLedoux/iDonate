<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Doadores Parceiros') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(request('q'))
                <div class="mb-6">
                    <p class="text-gray-600 dark:text-gray-300">Resultados da busca para: <span class="font-bold">"{{ request('q') }}"</span></p>
                </div>

                @if($companies->isNotEmpty())
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Doadores encontrados</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($companies as $company)
                                <a href="{{ route('companies.show', $company->id) }}" class="group block bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 transform hover:-translate-y-1">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div class="relative w-16 h-16 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 shrink-0">
                                            @if($company->logo_path)
                                                <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-8 h-8 text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg group-hover:text-orange-500 transition-colors">{{ $company->name }}</h3>
                                            <p class="text-sm text-gray-500 line-clamp-1">{{ $company->description ?? 'Parceiro iDonate' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-xs text-orange-600 font-semibold flex items-center">
                                        Mais detalhes e itens para doação
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($foodItems->isNotEmpty())
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Alimentos encontrados</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($foodItems as $item)
                                <a href="{{ route('food-items.show', $item->id) }}" class="block bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $item->title }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->company->name ?? 'Parceiro' }}</p>
                                        </div>
                                        <span class="text-sm font-semibold text-green-600">{{ $item->quantity }} un.</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ $item->description }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($events->isNotEmpty())
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Eventos encontrados</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($events as $event)
                                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $event->title }}</h4>
                                        <span class="text-xs uppercase tracking-wider text-green-600">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-3">{{ $event->description }}</p>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                                        <p><strong>Local:</strong> {{ $event->location }}</p>
                                        <p><strong>Organizador:</strong> {{ $event->creator->name ?? 'Anônimo' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($companies->isEmpty() && $foodItems->isEmpty() && $events->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-gray-400 dark:text-gray-600 mb-4 inline-block">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">Nenhum resultado encontrado</h3>
                        <p class="text-gray-500">Tente outra palavra-chave para encontrar doadores, alimentos ou eventos.</p>
                    </div>
                @endif
            @else
                @if($companies->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-gray-400 dark:text-gray-600 mb-4 inline-block">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">Nenhum doador encontrado</h3>
                        <p class="text-gray-500">Nenhum parceiro registado ainda ou sua busca não retornou resultados.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($companies as $company)
                            <a href="{{ route('companies.show', $company->id) }}" class="group block bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 transform hover:-translate-y-1">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="relative w-16 h-16 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 shrink-0">
                                        @if($company->logo_path)
                                            <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg group-hover:text-orange-500 transition-colors">{{ $company->name }}</h3>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ $company->description ?? 'Parceiro iDonate' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-orange-600 font-semibold flex items-center">
                                    Mais detalhes e itens para doação
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
