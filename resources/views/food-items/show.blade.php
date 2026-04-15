<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Detalhes do Alimento
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen relative overflow-hidden">
        <div class="absolute top-0 left-0 -ml-10 -mt-10 w-64 h-64 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-64 h-64 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 max-w-4xl mx-auto">
                <div class="md:flex">
                    <!-- Configurando a imagem -->
                    <div class="md:shrink-0 md:w-1/2 h-64 md:h-auto md:max-h-[500px] relative overflow-hidden bg-gray-100 dark:bg-gray-800">
                        @if($foodItem->image_path)
                            <img class="w-full h-full object-cover" src="{{ Storage::url($foodItem->image_path) }}" alt="{{ $foodItem->title }}">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-orange-100 to-red-100 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-orange-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4 bg-orange-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                            {{ $foodItem->quantity }} {{ $foodItem->quantity > 1 ? 'disponíveis' : 'disponível' }}
                        </div>
                    </div>

                    <!-- Conteúdo / Detalhes -->
                    <div class="p-8 md:p-10 flex flex-col justify-center">
                        <div class="uppercase tracking-wide text-sm text-orange-500 font-semibold mb-1">
                            Refeição Solidária
                        </div>
                        <h3 class="block mt-1 text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                            {{ $foodItem->title }}
                        </h3>

                        <div class="mt-6 flex flex-col space-y-4">
                            <!-- Empresa -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div class="ml-3 text-base text-gray-700 dark:text-gray-300">
                                    <span class="block font-semibold">Empresa/Doador:</span>
                                    {{ $foodItem->company->name ?? 'Empresa Desconhecida' }}
                                </div>
                            </div>

                            <!-- Localização -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="ml-3 text-base text-gray-700 dark:text-gray-300">
                                    <span class="block font-semibold">Localização:</span>
                                    @if($foodItem->company && $foodItem->company->location)
                                        {{ $foodItem->company->location }}
                                    @else
                                        <span class="text-gray-500 italic">Não informada</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                </div>
                                <div class="ml-3 text-base text-gray-700 dark:text-gray-300">
                                    <span class="block font-semibold">Descrição:</span>
                                    {{ $foodItem->description }}
                                </div>
                            </div>
                        </div>

                        <!-- Botão de Solicitação -->
                        <div class="mt-8">
                            @if(auth()->user()->role === 'receptor')
                                @if($foodItem->quantity > 0 && $foodItem->is_available)
                                    <form action="{{ route('donations.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="food_item_id" value="{{ $foodItem->id }}">
                                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 border border-transparent rounded-2xl py-3 px-8 flex items-center justify-center text-lg font-bold text-white hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-900 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            Adicionar à Lista de Pedidos
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-300 dark:bg-gray-700 border border-transparent rounded-2xl py-3 px-4 flex items-center justify-center text-lg font-bold text-gray-500 cursor-not-allowed">
                                        Indisponível no momento
                                    </button>
                                @endif
                            @else
                                <div class="p-4 bg-orange-50 dark:bg-orange-900/30 border border-orange-100 dark:border-orange-800/50 rounded-2xl text-center">
                                    <p class="text-sm text-orange-800 dark:text-orange-200">
                                        Para realizar pedidos desta comida, você precisaria estar logado como um <strong>Receptor</strong>. Seu tipo de acesso atual é <strong>{{ ucfirst(auth()->user()->role) }}</strong>.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 font-medium inline-flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Voltar para o Menu Inicial
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
