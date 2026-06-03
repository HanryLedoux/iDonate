@props(['foods'])

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Alimentos
        </h3>
        <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-sm font-semibold rounded-full">
            {{ $foods->count() }} item(s)
        </span>
    </div>

    @if($foods->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alimento</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Empresa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qtd</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Validade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($foods as $food)
                        @php
                            $expired = $food->expiry_date && $food->expiry_date->isPast();
                            $expiringSoon = $food->expiry_date && !$expired && $food->expiry_date->diffInDays(now()) <= 3;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('food-items.show', $food->id) }}" class="font-semibold text-gray-900 dark:text-white hover:text-orange-500 transition-colors">
                                    {{ $food->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $food->company->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">
                                {{ $food->quantity }}
                            </td>
                            <td class="px-6 py-4">
                                @if($expired)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Expirado
                                    </span>
                                @elseif(!$food->is_available)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Esgotado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disponível
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($food->expiry_date)
                                    <span class="font-medium {{ $expired ? 'text-red-600 dark:text-red-400' : ($expiringSoon ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400') }}">
                                        {{ $food->expiry_date->format('d/m/Y') }}
                                        @if($expiringSoon)
                                            <span class="text-xs ml-1">(vence em breve)</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto w-16 h-16 bg-orange-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-orange-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">Nenhum alimento cadastrado</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Os alimentos aparecerão aqui assim que forem cadastrados.</p>
        </div>
    @endif
</div>
