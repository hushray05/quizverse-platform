@props([
    'title' => 'Console',
    'breadcrumbs' => [],
])

@php
    $user = auth()->user();
@endphp

<header class="h-16 border-b border-slate-200 dark:border-zinc-800 bg-white/90 dark:bg-[#0B0F19]/90 backdrop-blur-xl sticky top-0 z-30 px-4 sm:px-6 lg:px-8 flex items-center justify-between transition-colors duration-200">
    <!-- Left: Mobile Hamburger Toggle & Breadcrumbs -->
    <div class="flex items-center gap-3">
        <!-- Hamburger ☰ button on mobile -->
        <button type="button" onclick="toggleSidebar(true)" class="md:hidden text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" aria-label="Toggle Navigation Drawer">
            <span class="text-2xl leading-none">☰</span>
        </button>

        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-white transition-colors flex items-center gap-1 font-semibold" title="Go to Public Homepage">
                <i class="fa-solid fa-house text-blue-600 dark:text-blue-400 text-xs"></i>
                <span class="hidden sm:inline">QuizVerse</span>
            </a>
            <span class="text-slate-400 dark:text-zinc-600">/</span>
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-white transition-colors font-semibold">Console</a>
            @foreach($breadcrumbs as $label => $url)
                @if($label !== 'Console')
                    <span class="text-slate-400 dark:text-zinc-600">/</span>
                    @if($url)
                        <a href="{{ $url }}" class="text-slate-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-zinc-200 transition-colors">{{ $label }}</a>
                    @else
                        <span class="text-[#0F172A] dark:text-zinc-100 font-bold">{{ $label }}</span>
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <!-- Right Controls: Theme Toggle & User Info (NO DEMO SWITCH HERE) -->
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Theme Toggle Button -->
        <button type="button" onclick="window.toggleTheme()" class="p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" title="Toggle Light / Dark Theme">
            <i class="fa-solid fa-sun hidden dark:inline text-amber-400 text-sm"></i>
            <i class="fa-solid fa-moon inline dark:hidden text-slate-700 text-sm"></i>
        </button>

        @if($user)
        <!-- Coins Counter -->
        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs font-mono font-semibold text-amber-600 dark:text-amber-400">
            <i class="fa-solid fa-coins text-amber-500 text-xs"></i>
            <span>{{ number_format($user->coins) }}</span>
        </div>

        <!-- User profile link -->
        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 p-1 rounded-full hover:ring-2 hover:ring-blue-500/50 transition-all" title="View Profile">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full border border-blue-500/40 object-cover" />
        </a>
        @endif
    </div>
</header>
