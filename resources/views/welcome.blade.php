<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SGI - ESG System') }}</title>

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col antialiased">
    
    <main class="flex max-w-[380px] w-full flex-col bg-white dark:bg-[#161615] shadow-lg rounded-xl p-8 border border-gray-200 dark:border-[#3E3E3A] text-center">
        
        <!-- Logo Vetorial SGI + ESG -->
        <div class="flex justify-center mb-6">
            <svg class="w-16 h-16 text-emerald-600 dark:text-emerald-500" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M32 8C20 8 12 18 12 30C12 42 22 52 32 56C42 52 52 42 52 30C52 18 44 8 32 8Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M32 54V20" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                <path d="M32 32L42 24" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                <path d="M32 40L22 32" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                <circle cx="32" cy="18" r="3" fill="currentColor"/>
            </svg>
        </div>

        <!-- Título e Subtítulo -->
        <h1 class="text-xl font-semibold mb-1">SGI & ESG System</h1>
        <p class="text-sm text-gray-500 dark:text-[#A1A09A] mb-8">
            Sistema Integrado de Gestão, Qualidade e Sustentabilidade
        </p>

        <!-- Ações de Acesso -->
        <div class="flex flex-col gap-3 w-full">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-md text-sm transition-colors shadow-sm">
                        Acessar Dashboard
                    </a>
                @else
                    @if (!\App\Models\User::exists() && !\App\Models\Empresa::exists())
                        <a href="{{ route('setup.create') }}" 
                           class="w-full py-2.5 px-4 bg-transparent border border-gray-300 dark:border-[#3E3E3A] hover:border-emerald-600 dark:hover:border-emerald-500 font-medium rounded-md text-sm transition-colors">
                            Primeiro Acesso (Configuração Inicial)
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-md text-sm transition-colors shadow-sm">
                            Entrar no Sistema
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Rodapé simples -->
        <footer class="mt-8 pt-4 border-t border-gray-100 dark:border-[#262624] text-xs text-gray-400 dark:text-gray-600">
            Qualidade & Governança Corporativa &copy; {{ date('Y') }}
        </footer>
    </main>

</body>
</html>
