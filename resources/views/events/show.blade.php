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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

                <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
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

                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Visão Geral') }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Este espaço exibe todos os detalhes do evento, para que qualquer usuário autenticado possa revisar a descrição e o local antes de decidir participar.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
