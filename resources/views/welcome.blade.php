<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>iDonate - Plataforma de Doação de Alimentos</title>
        <meta name="description" content="Conecte doadores, voluntários e receptores para transformar desperdício em solidariedade.">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Outfit', sans-serif; }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .float { animation: float 6s ease-in-out infinite; }
        </style>
    </head>
    <body class="antialiased min-h-screen flex flex-col" style="background:#0a0a14;color:#fff">

        {{-- Decorative blobs --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-5%] w-[500px] h-[500px] rounded-full filter blur-[120px] float" style="background:rgba(249,115,22,0.08)"></div>
            <div class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] rounded-full filter blur-[120px] float" style="background:rgba(239,68,68,0.06);animation-delay:3s"></div>
        </div>

        {{-- Navbar --}}
        <nav class="relative z-10 w-full" style="background:rgba(255,255,255,0.05);border-bottom:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(12px)">
            <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2.5">
                    <svg class="w-7 h-7" style="color:#f97316" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="text-xl font-bold" style="color:#f97316">iDonate</span>
                </a>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-semibold rounded-lg transition-colors" style="background:#f97316;color:#fff">Painel</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium transition-colors" style="color:#9ca3af">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold bg-orange-500 rounded-lg hover:bg-orange-600 transition-colors">Criar Conta</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        {{-- Hero --}}
        <main class="relative z-10 flex-1 flex items-center justify-center px-6">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="font-extrabold leading-tight mb-6" style="color:#fff;font-size:3.5rem">
                    Transforme excesso em<br>
                    <span style="background:linear-gradient(90deg,#fb923c,#ef4444);-webkit-background-clip:text;-webkit-text-fill-color:transparent">esperança.</span>
                </h1>

                <p class="text-lg leading-relaxed mb-8 max-w-lg mx-auto" style="color:#9ca3af">
                    O iDonate conecta empresas, voluntários e famílias para que alimentos cheguem a quem mais precisa.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full sm:w-1/2 text-center px-8 py-4 text-base font-bold rounded-xl hover:-translate-y-0.5 transition-all" style="background:linear-gradient(90deg,#f97316,#ef4444);color:#fff;box-shadow:0 8px 24px rgba(249,115,22,0.25)">
                            Comece Agora
                        </a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="w-full sm:w-1/2 text-center px-8 py-4 text-base font-bold rounded-xl transition-all" style="border:1px solid rgba(255,255,255,0.2);color:#d1d5db">
                            Já tenho conta
                        </a>
                    @endif
                </div>
            </div>
        </main>
        {{-- Footer --}}
        <footer class="relative z-10 py-6 text-center text-xs" style="color:#4b5563">
            &copy; {{ date('Y') }} iDonate — Transformando desperdício em solidariedade.
        </footer>

    </body>
</html>
