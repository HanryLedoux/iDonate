<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ __('Detalhes do Evento') }}
            </h2>
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100 rounded-lg shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Voltar para Eventos
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-5 py-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 px-5 py-4 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Card principal do evento -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="relative h-72 bg-gray-200 dark:bg-gray-700">
                    @if($event->image_path)
                        <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                            <div class="text-center px-6">
                                <p class="text-sm uppercase tracking-[0.3em] text-white/80 font-semibold">{{ __('Evento Solidário') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>

                <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm uppercase tracking-widest text-green-600 dark:text-green-300">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</p>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $event->title }}</h1>
                    <p class="text-sm mt-2 text-gray-600 dark:text-gray-300">{{ $event->location }}</p>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Descrição do Evento') }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Informações adicionais') }}</h2>
                                <dl class="grid grid-cols-1 gap-4 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Organizador') }}</dt>
                                        <dd>{{ $event->creator->name ?? __('Anônimo') }}</dd>
                                    </div>
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Localização') }}</dt>
                                        <dd>{{ $event->location }}</dd>
                                    </div>
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Data e Hora') }}</dt>
                                        <dd>{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Ação') }}</h2>
                                @if(Auth::user()->role !== 'receptor')
                                    <div class="rounded-3xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 p-5 text-yellow-800 dark:text-yellow-200">
                                        <p class="font-semibold">{{ __('Apenas receptores podem se inscrever neste evento.') }}</p>
                                        <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-200">{{ __('Você pode visualizar todos os detalhes, mas a inscrição não está disponível para doadores.') }}</p>
                                    </div>
                                @elseif(in_array($event->id, $userRegistrations))
                                    <div class="rounded-3xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 p-5 text-green-800 dark:text-green-200">
                                        <p class="font-semibold">{{ __('Você já está inscrito.') }}</p>
                                    </div>
                                @else
                                    <form action="{{ route('events.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-3xl font-bold transition">{{ __('Quero participar') }}</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção de Alimentos do Evento -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Alimentos no Evento
                    </h3>
                    <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-sm font-semibold rounded-full">
                        {{ $event->foodItems->count() }} item(s)
                    </span>
                </div>

                <!-- Form para doador adicionar alimento -->
                @if(Auth::user()->role === 'doador' && $myFoodItems->count() > 0)
                    <div class="px-6 py-4 bg-orange-50 dark:bg-orange-900/10 border-b border-orange-100 dark:border-orange-900/30">
                        <form action="{{ route('events.food-items.store', $event->id) }}" method="POST" class="flex gap-3 items-end">
                            @csrf
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Adicionar alimento ao evento</label>
                                <select name="food_item_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                    @foreach($myFoodItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-lg transition">
                                Adicionar
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Lista de alimentos -->
                @if($event->foodItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alimento</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status do Estoque</th>
                                    @if(Auth::user()->role === 'doador')
                                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alterar Status</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($event->foodItems as $food)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $food->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php $status = $food->pivot->stock_status; @endphp
                                            @if($status === 'available')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disponível
                                                </span>
                                            @elseif($status === 'running_low')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Acabando
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Esgotado
                                                </span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->role === 'doador')
                                            <td class="px-6 py-4">
                                                <form action="{{ route('events.food-items.status', [$event->id, $food->id]) }}" method="POST" class="flex gap-2 items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="stock_status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                                        <option value="available" {{ $food->pivot->stock_status === 'available' ? 'selected' : '' }}>Disponível</option>
                                                        <option value="running_low" {{ $food->pivot->stock_status === 'running_low' ? 'selected' : '' }}>Acabando</option>
                                                        <option value="out_of_stock" {{ $food->pivot->stock_status === 'out_of_stock' ? 'selected' : '' }}>Esgotado</option>
                                                    </select>
                                                    <button type="submit" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition">
                                                        Salvar
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('events.food-items.destroy', [$event->id, $food->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Remover este alimento do evento?')" class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                                        Remover
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum alimento vinculado a este evento ainda.</p>
                        @if(Auth::user()->role === 'doador' && $myFoodItems->count() === 0)
                            <p class="text-xs text-gray-400 mt-1">Cadastre alimentos na sua empresa para adicioná-los aqui.</p>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
