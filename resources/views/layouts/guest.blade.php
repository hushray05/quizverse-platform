<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Access Portal' }} | QuizVerse</title>
    <meta name="description" content="QuizVerse - Next-generation competitive knowledge engine.">

    <!-- Inline script to set default light theme or stored dark theme without FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Offline Bundled Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-[#0F172A] dark:bg-[#0B0F19] dark:text-[#F8FAFC] min-h-screen font-sans antialiased flex flex-col justify-between selection:bg-blue-500/20 selection:text-blue-700 transition-colors duration-200">
    <!-- Clean Guest Top Nav without Demo Credentials in Header -->
    <header class="h-16 border-b border-slate-200 dark:border-zinc-800 bg-white/90 dark:bg-[#0B0F19]/90 backdrop-blur-md px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" title="Return to Homepage">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#2563EB] to-indigo-600 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-atom text-white text-base"></i>
            </div>
            <span class="text-base font-extrabold tracking-tight text-[#0F172A] dark:text-[#F8FAFC] flex items-center gap-1.5">
                QuizVerse
                <span class="text-[9px] px-1.5 py-0.2 rounded font-mono font-semibold bg-blue-500/10 dark:bg-blue-500/20 text-[#2563EB] dark:text-[#3B82F6] border border-blue-500/30">2026</span>
            </span>
        </a>

        <!-- Right: Theme Toggle & Navigation Links (NO DEMO SWITCH HERE) -->
        <div class="flex items-center gap-3 text-xs">
            <!-- Theme Toggle Button -->
            <button type="button" onclick="window.toggleTheme()" class="p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" title="Toggle Light / Dark Theme">
                <i class="fa-solid fa-sun hidden dark:inline text-amber-400 text-sm"></i>
                <i class="fa-solid fa-moon inline dark:hidden text-slate-700 text-sm"></i>
            </button>

            <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:text-[#2563EB] dark:hover:text-[#3B82F6] font-medium transition-colors">
                <i class="fa-solid fa-house mr-1"></i> Home
            </a>
            
            <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('login') ? 'bg-blue-50 dark:bg-blue-900/40 text-[#2563EB] dark:text-[#3B82F6] font-bold' : 'text-slate-600 dark:text-slate-300' }} transition-colors">
                Log In
            </a>

            <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white font-bold shadow-sm transition-all">
                Sign Up
            </a>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 md:p-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-slate-200 dark:border-zinc-800 px-6 py-4 text-center text-xs text-slate-500 dark:text-zinc-500 font-mono">
        <span>QuizVerse Competitive Neural Engine • Offline 2026 Standard</span>
    </footer>

    <!-- Offline Flash Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('success', @json(session('success')));
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('error', @json(session('error')));
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('info', @json(session('info')));
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
