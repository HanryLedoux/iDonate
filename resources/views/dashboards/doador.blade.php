<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 rounded-3xl shadow-2xl overflow-hidden mb-8 relative">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 200" fill="none"><circle cx="350" cy="30" r="120" fill="white"/><circle cx="50" cy="180" r="80" fill="white"/></svg>
                </div>
                <div class="p-8 md:p-12 relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <p class="text-orange-100 text-sm font-medium mb-1">Painel do Doador</p>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">
                                Bem-vindo, {{ Auth::user()->company->name ?? Auth::user()->name }}! 🤝
                            </h1>
                            <p class="text-orange-100 text-base max-w-lg">
                                Gerencie seus alimentos e eventos solidários. Cada doação transforma vidas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('perfil.show') }}" class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-orange-300 dark:hover:border-orange-600 transition-all duration-200 transform hover:-translate-y-0.5">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-orange-600 transition-colors">Ofertar Alimento</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Disponibilize uma nova refeição para doação.</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('events.create') }}" class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-green-300 dark:hover:border-green-600 transition-all duration-200 transform hover:-translate-y-0.5">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">Criar Evento Solidário</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Organize uma ação de arrecadação ou entrega.</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('feedback.index') }}" class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-purple-300 dark:hover:border-purple-600 transition-all duration-200 transform hover:-translate-y-0.5">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-purple-600 transition-colors">Enviar Feedback</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Envie sugestões para melhorar a plataforma.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Food Items List -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between gap-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Meus Alimentos
                            </h3>
                            <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-sm font-semibold rounded-full">{{ $foodItems->count() }} Ativos</span>
                        </div>

                        <div class="p-6">
                            @if($foodItems->count() > 0)
                                <div class="space-y-4">
                                    @foreach($foodItems as $food)
                                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-orange-300 dark:hover:border-orange-500 transition-colors">
                                            <div class="w-16 h-16 rounded-xl bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden mr-4">
                                                @if($food->image_path)
                                                    <img src="{{ Storage::url($food->image_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0 pr-4">
                                                <h4 class="text-base font-bold text-gray-900 dark:text-white truncate">{{ $food->title }}</h4>
                                                <div class="flex gap-3 text-sm mt-1">
                                                    <span class="text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($food->created_at)->format('d/m') }}</span>
                                                    @if($food->is_available)
                                                        <span class="text-green-600 dark:text-green-400 font-semibold flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></span> Disponível</span>
                                                    @else
                                                        <span class="text-red-600 dark:text-red-400 font-semibold flex items-center"><span class="w-2 h-2 rounded-full bg-red-500 mr-1.5"></span> Esgotado</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-black text-gray-800 dark:text-white">{{ $food->quantity }}</div>
                                                <div class="text-xs text-gray-500 uppercase tracking-wide">QTD</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="mx-auto w-16 h-16 bg-orange-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-orange-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">Nenhum alimento cadastrado</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Acesse seu perfil para criar a primeira doação.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar: My Events -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Meus Eventos
                            </h3>
                            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-500 transition-colors">Ver Todos</a>
                        </div>

                        @if($myEvents->count() > 0)
                            <div class="space-y-3">
                                @foreach($myEvents as $event)
                                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-600 transition-colors">
                                        <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-black text-green-600 dark:text-green-400">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $event->title }}</h4>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                <span class="truncate">{{ $event->location }}</span>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-green-600 bg-green-100 dark:text-green-400 dark:bg-green-900/30 px-2 py-1 rounded-lg flex-shrink-0">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-sm">Você não organizou nenhum evento ainda.</p>
                                <a href="{{ route('events.create') }}" class="text-sm font-semibold text-green-600 hover:text-green-500 mt-2 inline-block">Criar Evento →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
