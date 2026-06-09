<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
            <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="title" :value="__('Título do Evento')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500" required autofocus value="{{ old('title', $event->title) }}" placeholder="Ex: Mutirão de Doação no Centro" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm block mt-1 w-full" required placeholder="Detalhes de como funcionará a distribuição...">{{ old('description', $event->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="event_date" :value="__('Data e Hora')" />
                                <x-text-input id="event_date" name="event_date" type="datetime-local" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500" required value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\\TH:i')) }}" />
                                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Localização / Endereço')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500" required placeholder="Rua XYZ, 123" value="{{ old('location', $event->location) }}" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Capa do Evento (Opcional)')" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg hover:border-green-500 transition-colors bg-gray-50 dark:bg-gray-800/50">
                                <div class="space-y-1 text-center">
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <label for="image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-green-600 dark:text-green-400 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500 text-center">
                                            <span id="event-file-name">{{ $event->image_path ? basename($event->image_path) : 'Faça upload de um arquivo' }}</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg" onchange="document.getElementById('event-file-name').textContent = this.files[0] ? this.files[0].name : '{{ $event->image_path ? basename($event->image_path) : 'Faça upload de um arquivo' }}'">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF até 10MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('events.show', $event->id) }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancelar</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-green-500/30 transform hover:-translate-y-0.5">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
