<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            {{ __('Meus Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-r shadow-sm flex gap-3 items-center">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($myDonations->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 text-center border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="mx-auto w-16 h-16 bg-orange-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-orange-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Você ainda não solicitou nenhuma doação</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Explore os alimentos disponíveis no seu painel e solicite uma doação.</p>
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Explorar Alimentos
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($myDonations as $donation)
                        <div class="donation-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:shadow-md transition-shadow">
                            {{-- Food thumbnail --}}
                            <div class="w-14 h-14 rounded-xl bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                @if($donation->foodItem->image_path)
                                    <img src="{{ Storage::url($donation->foodItem->image_path) }}" class="w-full h-full object-cover" alt="{{ $donation->foodItem->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-gray-900 dark:text-white truncate">{{ $donation->foodItem->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center mt-0.5">
                                    <svg class="w-3.5 h-3.5 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $donation->foodItem->company->name ?? 'Empresa Desconhecida' }}
                                </p>
                            </div>

                            {{-- Date --}}
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center whitespace-nowrap">
                                <svg class="w-4 h-4 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $donation->created_at->format('d/m/Y') }}
                            </div>

                            {{-- Quantity and Status + Actions --}}
                            <div class="flex items-center gap-3">
                                <div class="text-sm text-gray-600 dark:text-gray-300">Qtd: <strong class="donation-quantity text-gray-900 dark:text-white">{{ $donation->quantity ?? 1 }}</strong></div>
                                <div>
                                    @if($donation->status === 'pending')
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pendente</span>
                                    @elseif($donation->status === 'approved')
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Aprovado</span>
                                    @elseif($donation->status === 'delivered')
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Entregue</span>
                                    @else
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Cancelado</span>
                                    @endif
                                </div>

                                @if(Auth::id() == $donation->user_id && $donation->status === 'pending')
                                    <button data-donation-id="{{ $donation->id }}" data-donation-qty="{{ $donation->quantity ?? 1 }}" class="ml-2 px-3 py-1.5 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition cancel-donation">Cancelar</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

{{-- Non-blocking confirmation modal for canceling donations --}}
<div id="cancel-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 px-4">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="p-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cancelar pedido</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Tem certeza que deseja cancelar este pedido? Esta ação pode ser desfeita apenas pelo sistema.</p>
            <div class="mt-4">
                <label for="cancel-modal-qty" class="text-sm text-gray-700 dark:text-gray-300">Quantidade a cancelar</label>
                <div class="mt-2 flex items-center gap-3">
                    <input id="cancel-modal-qty" type="number" min="1" value="1" class="w-24 px-3 py-2 rounded-md border text-black dark:text-black placeholder-gray-500" />
                    <div class="text-sm text-gray-500 dark:text-gray-400">Máximo disponível: <span id="cancel-modal-max">0</span></div>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <button id="cancel-modal-close" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-200">Fechar</button>
                    <button id="cancel-modal-confirm" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Confirmar cancelamento</button>
                </div>
            </div>
        </div>
    </div>
</div>
