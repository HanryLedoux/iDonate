<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'iDonate') }} - Compartilhe Alimentos, Espalhe Esperança</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            input, select, textarea { color: #111 !important; }
            input::placeholder, textarea::placeholder { color: #9ca3af !important; }
        </style>
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="font-sans antialiased min-h-screen" style="background:#0a0a14;color:#fff">
        <div class="min-h-screen flex">
            <!-- Left Side: Image (Hidden on small screens) -->
            <div class="hidden lg:flex lg:w-1/2 relative" style="background:#f97316">
                <img src="https://images.unsplash.com/photo-1593113630400-ea4288922497?q=80&w=2070&auto=format&fit=crop" 
                     alt="Voluntários doando alimentos" 
                     class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-overlay">
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(10,10,20,0.85), transparent)"></div>
                <div class="z-10 relative flex flex-col justify-end p-12 text-white h-full">
                    <h1 class="text-5xl font-bold mb-4 tracking-tight">Juntos podemos alimentar a esperança.</h1>
                    <p class="text-xl font-light max-w-lg mb-8" style="color:rgba(255,255,255,0.8)">Conecte-se com doadores, voluntários e receptores para transformar desperdício em solidariedade.</p>
                </div>
            </div>

            <!-- Right Side: Auth Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden">
                <!-- Decorative blurred circles -->
                <div class="absolute top-[-10%] right-[-10%] w-96 h-96 rounded-full filter blur-3xl" style="background:rgba(249,115,22,0.08)"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 rounded-full filter blur-3xl" style="background:rgba(239,68,68,0.06)"></div>
                
                <div class="w-full max-w-md relative z-10 p-8 rounded-3xl shadow-2xl" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(12px)">
                    <div class="mb-8 text-center">
                        <a href="/" class="inline-block transition-transform hover:scale-105">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-10 h-10" style="color:#f97316" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="text-3xl font-extrabold" style="color:#f97316">iDonate</span>
                            </div>
                        </a>
                        <p class="mt-2 text-sm" style="color:#6b7280">Plataforma de Doação de Alimentos</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
