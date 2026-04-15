<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Olá, ') }} {{ Auth::user()->name ?? 'Voluntário' }}! 👋
            </h2>
            <div class="text-sm text-gray-500">Pronto para causar impacto hoje?</div>
        </div>
    </x-slot>

    <div class="py-12 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- Hero Stats or Welcome -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl shadow-xl overflow-hidden mb-8 transform transition hover:scale-[1.01] duration-300 relative group cursor-pointer">
                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="p-8 sm:p-12 text-white">
                    <h3 class="text-3xl font-extrabold mb-2">Central de Doações</h3>
                    <p class="text-orange-100 max-w-2xl text-lg">Encontre alimentos disponíveis para coleta, participe de eventos solidários e acompanhe o fluxo de doações em tempo real na plataforma.</p>
                </div>
            </div>

            <!-- Dashboard Options Menu -->
            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-6">Menu Rápido</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Food Listings -->
                <a href="{{ route('companies.index') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="h-32 bg-orange-100 relative">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover mix-blend-overlay" alt="Alimentos">
                        <div class="absolute inset-x-0 bottom-0 isolate overflow-hidden p-4">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent z-0"></div>
                            <h4 class="text-xl font-bold text-white relative z-10">Alimentos</h4>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Navegue pelas empresas e veja os alimentos disponíveis para doação.</p>
                    </div>
                </a>

                <!-- Events -->
                <a href="{{ route('events.index') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="h-32 bg-green-100 relative">
                        <img src="https://images.unsplash.com/photo-1593113565214-80afcb4a4571?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover mix-blend-overlay" alt="Eventos">
                        <div class="absolute inset-x-0 bottom-0 isolate overflow-hidden p-4">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent z-0"></div>
                            <h4 class="text-xl font-bold text-white relative z-10">Eventos</h4>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Inscreva-se em eventos de distribuição, mutirões e ações beneficentes.</p>
                    </div>
                </a>

                <!-- Tracking -->
                <a href="{{ route('donations.index') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="h-32 bg-blue-100 relative">
                        <img src="https://images.unsplash.com/photo-1616401784845-180882ba9ba8?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover mix-blend-overlay" alt="Rastreamento">
                        <div class="absolute inset-x-0 bottom-0 isolate overflow-hidden p-4">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent z-0"></div>
                            <h4 class="text-xl font-bold text-white relative z-10">Status das Doações</h4>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Acompanhe as confirmações e o fluxo de entregas de alimentos.</p>
                    </div>
                </a>

                <!-- Feedback -->
                <a href="{{ route('feedback.index') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="h-32 bg-purple-100 relative">
                        <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover mix-blend-overlay" alt="Feedback">
                        <div class="absolute inset-x-0 bottom-0 isolate overflow-hidden p-4">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent z-0"></div>
                            <h4 class="text-xl font-bold text-white relative z-10">Feedback</h4>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Envie críticas e sugestões para melhorar nossa plataforma.</p>
                    </div>
                </a>
            </div>
            </div>

            <!-- Alimentos Disponíveis -->
            <div class="mt-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">Alimentos Disponíveis para Coleta</h3>
                </div>

                @if(isset($foodItems) && $foodItems->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($foodItems as $food)
                            <a href="{{ route('food-items.show', $food->id) }}" class="group block bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <div class="h-48 relative overflow-hidden">
                                    @if($food->image_path)
                                        <img src="{{ Storage::url($food->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $food->title }}">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-red-100 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center transition-transform duration-500 group-hover:scale-110">
                                            <svg class="w-12 h-12 text-orange-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm dark:bg-gray-900/90 text-orange-600 dark:text-orange-400 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                        {{ $food->quantity }} {{ $food->quantity > 1 ? 'disponíveis' : 'disponível' }}
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-orange-500 transition-colors">{{ $food->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $food->company->name ?? 'Empresa Desconhecida' }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-10 text-center border border-gray-100 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 dark:bg-gray-700 mb-4 text-orange-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Nenhum alimento disponível</h4>
                        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">No momento, não há alimentos listados para coleta. Verifique novamente mais tarde!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
