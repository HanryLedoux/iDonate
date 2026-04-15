<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
            <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            {{ __('Enviar Feedback') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">Sua opinião é fundamental para melhorarmos a plataforma e ajudarmos ainda mais pessoas. Conta pra gente: o que você achou, encontrou algum erro ou tem alguma sugestão?</p>
                    
                    @if (session('status') === 'feedback-sent')
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm flex gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <p>Obrigado! Seu feedback foi enviado com sucesso.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('feedback.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="type" :value="__('Tipo de Feedback')" />
                            <select id="type" name="type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="suggestion">Sugestão de Melhoria</option>
                                <option value="bug">Reportar um Problema/Bug</option>
                                <option value="praise">Elogio</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="message" :value="__('Sua Mensagem')" />
                            <textarea id="message" name="message" rows="5" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded-md shadow-sm block mt-1 w-full" required placeholder="Descreva aqui com o máximo de detalhes..."></textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg shadow-purple-500/30 transform hover:-translate-y-0.5">
                                {{ __('Enviar Feedback') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
