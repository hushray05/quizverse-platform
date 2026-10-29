<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $quiz->title ?? 'Live Trial' }} | QuizVerse Arena</title>

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
<body class="bg-[#F8FAFC] text-[#0F172A] dark:bg-[#0B0F19] dark:text-[#F8FAFC] min-h-screen font-sans flex flex-col justify-between antialiased selection:bg-blue-500/20 selection:text-blue-700 mesh-glow overflow-x-hidden transition-colors duration-200">
    {{ $slot }}

    @stack('scripts')
</body>
</html>
