<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-500 rounded-3xl shadow-2xl overflow-hidden mb-8 relative">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 200" fill="none"><circle cx="350" cy="30" r="120" fill="white"/><circle cx="50" cy="180" r="80" fill="white"/></svg>
                </div>
                <div class="p-8 md:p-12 relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Painel do Receptor</p>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">
                                Olá, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="text-blue-100 text-base max-w-lg">
                                Encontre alimentos disponíveis para coleta e acompanhe seus pedidos com facilidade.
                            </p>
                        </div>
                        <a href="{{ route('companies.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-sm shrink-0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Buscar Doadores
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main: Available Foods -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Alimentos Disponíveis
                        </h3>
                    </div>

                    @if($availableFoods->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($availableFoods as $food)
                                <a href="{{ route('food-items.show', $food->id) }}" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg hover:border-orange-300 dark:hover:border-orange-600 transition-all duration-200 transform hover:-translate-y-0.5">
                                    <div class="h-40 relative">
                                        @if($food->image_path)
                                            <img src="{{ Storage::url($food->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $food->title }}">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-red-50 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                                <svg class="w-10 h-10 text-orange-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm dark:bg-gray-900/90 text-orange-600 dark:text-orange-400 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                                            {{ $food->quantity }} disp.
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 line-clamp-1 group-hover:text-orange-500 transition-colors">{{ $food->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $food->company->name ?? 'Empresa Desconhecida' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="mx-auto w-16 h-16 bg-orange-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-orange-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">Nenhum alimento disponível</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Fique de olho, novas doações aparecem a qualquer instante!</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar: My Requests -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Meus Pedidos
                            </h3>
                            <a href="{{ route('donations.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500 transition-colors">Ver Todos</a>
                        </div>

                        @if($myRequests->count() > 0)
                            <div class="space-y-3">
                                @foreach($myRequests as $request)
                                    <a href="{{ route('food-items.show', $request->foodItem->id) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-xl transition-colors border border-gray-100 dark:border-gray-600">
                                        <div class="w-11 h-11 rounded-lg bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                            @if($request->foodItem->image_path)
                                                <img src="{{ Storage::url($request->foodItem->image_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $request->foodItem->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $request->foodItem->company->name ?? 'Empresa' }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if($request->status === 'pending')
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pendente</span>
                                            @elseif($request->status === 'approved')
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Aprovado</span>
                                            @elseif($request->status === 'delivered')
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Entregue</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Cancelado</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-sm">Você ainda não solicitou nenhum alimento.</p>
                                <a href="{{ route('companies.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500 mt-2 inline-block">Buscar Doadores →</a>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-[calc(24px+400px)] mt-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Acesso Rápido
                        </h3>
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
        </div>
    </div>
</x-app-layout>
