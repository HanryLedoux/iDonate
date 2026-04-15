<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" style="color:#d1d5db" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" style="color:#d1d5db" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" style="background:#fff;border-color:rgba(255,255,255,0.2);color:#111" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-transparent text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm" style="color:#9ca3af">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold uppercase tracking-widest transition-all hover:-translate-y-0.5" style="background:linear-gradient(90deg,#f97316,#ef4444);color:#fff;box-shadow:0 4px 16px rgba(249,115,22,0.25)">
                {{ __('Entrar') }}
            </button>
        </div>

        <div class="flex items-center justify-between mt-5">
            <div>
                @if (Route::has('register'))
                    <a class="text-sm font-semibold hover:underline" style="color:#f97316" href="{{ route('register') }}">
                        {{ __('Criar conta') }}
                    </a>
                @endif
            </div>

            <div>
                @if (Route::has('password.request'))
                    <a class="text-sm hover:underline" style="color:#6b7280" href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>
