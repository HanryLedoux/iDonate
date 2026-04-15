<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" style="color:#d1d5db" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" style="color:#d1d5db" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" style="color:#d1d5db" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" style="color:#d1d5db" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Option -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Tipo de Usuário')" style="color:#d1d5db" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm" required style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111">
                <option value="voluntario" {{ old('role') == 'voluntario' ? 'selected' : '' }}>Voluntário</option>
                <option value="doador" {{ old('role') == 'doador' ? 'selected' : '' }}>Doador</option>
                <option value="receptor" {{ old('role') == 'receptor' ? 'selected' : '' }}>Receptor</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm font-semibold text-orange-600 hover:text-orange-500" href="{{ route('login') }}">
                {{ __('Já tem uma conta? Entrar') }}
            </a>

            <x-primary-button class="ms-4 bg-orange-600 hover:bg-orange-700">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
