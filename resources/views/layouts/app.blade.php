<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Console' }} | QuizVerse</title>
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
<body class="bg-[#F8FAFC] text-[#0F172A] dark:bg-[#0B0F19] dark:text-[#F8FAFC] min-h-screen font-sans flex flex-col antialiased transition-colors duration-200">
    
    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebar-backdrop" onclick="toggleSidebar(false)" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <div class="flex min-h-screen w-full overflow-x-hidden">
        <!-- Sidebar Navigation (Responsive Drawer on Mobile) -->
        <x-sidebar />

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0 w-full overflow-x-hidden">
            <x-navbar :title="$title ?? 'Console'" :breadcrumbs="$breadcrumbs ?? []" />

            <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-7xl mx-auto min-w-0">
                {{ $slot }}
            </main>

            <!-- Minimal Footer -->
            <footer class="border-t border-slate-200 dark:border-zinc-800/80 px-6 py-4 text-center text-xs text-slate-500 dark:text-zinc-400 font-mono flex flex-col sm:flex-row items-center justify-between gap-2 bg-white/60 dark:bg-zinc-950/60">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>QuizVerse Neural Engine v2026.4.1 — All Systems Operational</span>
                </div>
                <div>
                    <span>Offline Assets Bundled • No External CDN Dependencies</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Global Scripts -->
    <script>
        window.toggleSidebar = function(show) {
            const sidebar = document.getElementById('app-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar) return;
            if (typeof show === 'undefined') {
                show = sidebar.classList.contains('-translate-x-full');
            }
            if (show) {
                sidebar.classList.remove('-translate-x-full');
                if (backdrop) backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                if (backdrop) backdrop.classList.add('hidden');
            }
        };
    </script>

    <!-- Offline Flash Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('success', @json(session('success')), 'Operation Complete');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('error', @json(session('error')), 'Notice');
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.notify('info', @json(session('info')), 'Platform Advisory');
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
