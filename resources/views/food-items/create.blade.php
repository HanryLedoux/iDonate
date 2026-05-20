<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Adicionar Alimento: ') }} {{ $company->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('food-items.store', $company->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="title" :value="__('Título / Nome do Alimento')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500" required autofocus placeholder="Ex: Cesta Básica, 5kg de Arroz, etc." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descrição e Validade')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm block mt-1 w-full" required placeholder="Detalhes dos itens, data de validade, cuidados..."></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="quantity" :value="__('Quantidade Disponível (Unidades/Kilos)')" />
                            <x-text-input id="quantity" name="quantity" type="number" min="1" value="1" class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Foto do Alimento (Opcional)')" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg hover:border-orange-500 transition-colors bg-gray-50 dark:bg-gray-800/50">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <label for="image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 text-center">
                                            <span>Selecionar foto</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG até 10MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('companies.show', $company->id) }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancelar</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5">
                                Adicionar Alimento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
