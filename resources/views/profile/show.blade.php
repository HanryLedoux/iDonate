<x-app-layout>
    <!-- Main Container -->
    <div class="py-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Profile Card -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Cover Banner -->
            <div class="h-52 md:h-64 bg-gradient-to-br from-orange-400 via-red-500 to-pink-500 relative">
                @if($profileUser->role === 'doador' && $profileUser->company && $profileUser->company->logo_path)
                    <img src="{{ Storage::url($profileUser->company->logo_path) }}" class="w-full h-full object-cover mix-blend-overlay opacity-50 blur-sm" alt="Capa">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            </div>

            <!-- Profile Info -->
            <div class="px-8 md:px-12 pb-12 pt-0 relative">
                <!-- Avatar -->
                <div class="flex justify-center -mt-16 mb-6">
                    <div class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 bg-gradient-to-br from-orange-100 to-orange-50 dark:from-gray-700 dark:to-gray-600 shadow-xl flex items-center justify-center overflow-hidden ring-4 ring-orange-500/20" style="min-width:128px;min-height:128px;max-width:128px;max-height:128px;">
                        @if($profileUser->role === 'doador' && $profileUser->company && $profileUser->company->logo_path)
                            <img src="{{ Storage::url($profileUser->company->logo_path) }}" class="w-full h-full object-cover" alt="Avatar">
                        @else
                            <span class="text-5xl font-bold text-orange-500 leading-none select-none">{{ strtoupper(substr($profileUser->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Name + Role -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center gap-3 mb-3">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
                            {{ $profileUser->company->name ?? $profileUser->name }}
                        </h1>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $profileUser->role === 'doador' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300' : '' }}
                            {{ $profileUser->role === 'voluntario' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                            {{ $profileUser->role === 'receptor' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                        ">
                            {{ ucfirst($profileUser->role) }}
                        </span>
                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Membro da plataforma iDonate desde {{ $profileUser->created_at->format('Y') }}
                    </p>

                    @if($profileUser->role === 'doador' && $profileUser->company && $profileUser->company->location)
                        <div class="flex items-center justify-center text-gray-500 dark:text-gray-400 text-sm mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $profileUser->company->location }}
                        </div>
                    @endif
                </div>

                <!-- Action Button -->
                <div class="flex justify-center">
                    @if(Auth::id() === $profileUser->id)
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-full font-bold text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Editar Configurações
                        </a>
                    @else
                        <button class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 border border-transparent rounded-full font-bold text-sm text-white hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Contato
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- About Section -->
        @if($profileUser->role === 'doador' && $profileUser->company && $profileUser->company->description)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-8 mb-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Sobre
                </h3>
                <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                    {{ $profileUser->company->description }}
                </p>
            </div>
        @endif

        <!-- CTA: Ofertar Alimento (only for own profile if doador) -->
        @if($profileUser->role === 'doador' && Auth::check() && Auth::id() === $profileUser->id)
            <div class="mb-6">
                <a href="{{ route('food-items.create', $profileUser->company->id ?? 0) }}" class="group relative overflow-hidden bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg p-6 text-white transform transition hover:-translate-y-1 hover:shadow-xl block">
                    <div class="absolute right-0 top-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <h3 class="text-2xl font-black mb-1">Ofertar Alimento</h3>
                            <p class="text-orange-100 text-sm">Disponibilize hoje uma nova refeição para doação.</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        <!-- Activity Feed Section -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Atividade Recente
            </h3>

            @if($profileUser->role === 'doador')
                <!-- Donor Food Items list -->
                @if($profileUser->company && $profileUser->company->foodItems->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($profileUser->company->foodItems as $food)
                            <a href="{{ route('food-items.show', $food->id) }}" class="flex bg-gray-50 dark:bg-gray-700/30 rounded-xl overflow-hidden hover:shadow-lg transition-shadow border border-gray-100 dark:border-gray-700">
                                <div class="w-32 h-auto flex-shrink-0">
                                    @if($food->image_path)
                                        <img src="{{ Storage::url($food->image_path) }}" alt="{{ $food->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-orange-100 dark:bg-gray-600 flex items-center justify-center min-h-[80px]">
                                            <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-center">
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $food->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $food->description }}</p>
                                    <div class="mt-2 text-xs font-semibold {{ $food->is_available ? 'text-green-600 dark:text-green-400' : 'text-red-500' }}">
                                        {{ $food->quantity }} disponíveis
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        Nenhum alimento disponibilizado ainda.
                    </div>
                @endif
            @elseif($profileUser->role === 'voluntario' && count($events) > 0)
                <div class="space-y-4">
                    @foreach($events as $event)
                        <div class="flex flex-col sm:flex-row bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="mb-3 sm:mb-0 sm:mr-6 flex-shrink-0 text-center bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-100 dark:border-gray-600 min-w-[80px]">
                                <div class="text-xl font-extrabold text-orange-500">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                <div class="text-xs font-bold text-gray-500 uppercase">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $event->title }}</h4>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $event->location }}
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm line-clamp-2">{{ $event->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                    Ainda não há atividades recentes para exibir.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
