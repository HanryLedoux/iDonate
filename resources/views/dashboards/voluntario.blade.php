<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl shadow-xl mb-8">
                <div class="p-8 md:p-10">
                    <p class="text-green-100 text-sm font-medium mb-1">Painel do Voluntário</p>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                        Olá, {{ Auth::user()->name }}! 🌟
                    </h1>
                    <p class="text-green-100 text-sm max-w-lg mb-5">
                        Sua dedicação faz a diferença. Confira os próximos eventos e continue transformando vidas.
                    </p>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white text-green-600 font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Explorar Eventos
                    </a>
                </div>
            </div>

            <!-- Stats Row -->
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;" class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div style="width:48px;height:48px;min-width:48px;" class="rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $myRegistrations->count() }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Inscrições</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div style="width:48px;height:48px;min-width:48px;" class="rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $upcomingEvents->count() }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Eventos Próximos</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div style="width:48px;height:48px;min-width:48px;" class="rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">iDonate</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Comunidade</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:2rem;">

                <!-- Upcoming Events -->
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">Próximos Eventos</h3>
                        <a href="{{ route('events.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-500">Ver Todos →</a>
                    </div>

                    @if($upcomingEvents->count() > 0)
                        <div style="display:flex;flex-direction:column;gap:1rem;">
                            @foreach($upcomingEvents as $event)
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:border-green-300 dark:hover:border-green-600 transition-all" style="display:flex;gap:1.25rem;align-items:center;">
                                    <div style="width:72px;min-width:72px;text-align:center;" class="bg-green-50 dark:bg-gray-700 rounded-xl p-3">
                                        <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $event->title }}</h4>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $event->location }}
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" style="overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $event->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 text-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div style="width:64px;height:64px;margin:0 auto 1rem;" class="bg-green-50 dark:bg-gray-700 rounded-full flex items-center justify-center text-green-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">Nenhum evento próximo</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Novos eventos solidários podem surgir a qualquer momento!</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    <!-- My Registrations -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Minhas Inscrições</h3>

                        @if($myRegistrations->count() > 0)
                            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                                @foreach($myRegistrations as $reg)
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600">
                                        <div style="width:40px;height:40px;min-width:40px;" class="rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                            <span class="text-sm font-black text-green-600 dark:text-green-400">{{ \Carbon\Carbon::parse($reg->event->event_date)->format('d') }}</span>
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <p class="text-sm font-bold text-gray-900 dark:text-white" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $reg->event->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($reg->event->event_date)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma inscrição encontrada.</p>
                                <a href="{{ route('events.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-500 mt-2 inline-block">Explorar Eventos →</a>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Acesso Rápido</h3>
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            <a href="{{ route('perfil.show') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div style="width:36px;height:36px;min-width:36px;" class="rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Meu Perfil</span>
                            </a>
                            <a href="{{ route('feedback.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div style="width:36px;height:36px;min-width:36px;" class="rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Enviar Feedback</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div style="width:36px;height:36px;min-width:36px;" class="rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Configurações</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tabela de Alimentos -->
            <div class="mt-8">
                <x-food-items-table :foods="$allFoods" />
            </div>

        </div>
    </div>
</x-app-layout>
