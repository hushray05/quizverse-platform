<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QuizVerse — Competitive Trivia & Knowledge Engine</title>
    <meta name="description" content="Test your knowledge, discover new challenges, earn achievements, and see how you rank against other players worldwide.">

    <!-- Inline script to set default light theme or stored dark theme without FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Bundled offline assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#F8FAFC] text-[#0F172A] dark:bg-[#0B0F19] dark:text-[#F8FAFC] font-sans antialiased flex flex-col transition-colors duration-200" x-data="{ open: false }">

    <!-- Top Sticky Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 dark:bg-[#0B0F19]/90 backdrop-blur-md border-b border-slate-200 dark:border-zinc-800 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-[68px] max-w-7xl mx-auto px-4 md:px-8 flex items-center justify-between gap-4">
            
            <!-- Brand & Navigation -->
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-atom text-white text-base"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-[#0F172A] dark:text-[#F8FAFC]">QuizVerse</span>
                </a>

                <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold transition-colors">Home</a>
                    <a href="{{ route('explore') }}" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">Explore Quizzes</a>
                    <a href="#categories" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">Categories</a>
                    <a href="{{ route('play.daily') }}" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">Daily Challenge</a>
                    <a href="{{ route('leaderboard') }}" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">Leaderboard</a>
                </nav>
            </div>

            <!-- Right Controls: Theme Toggle, Quick Auth & Hamburger -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Theme Toggle Button -->
                <button type="button" onclick="window.toggleTheme()" class="p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" title="Toggle Light / Dark Mode">
                    <i class="fa-solid fa-sun hidden dark:inline text-amber-400 text-lg"></i>
                    <i class="fa-solid fa-moon inline dark:hidden text-slate-700 text-lg"></i>
                </button>

                <!-- Action / Auth Buttons -->
                <a href="{{ route('play.quick') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm shadow-sm hover:opacity-95 transition-all hover:scale-[1.02]">
                    Play Now
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-sm">
                        <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        <span class="font-semibold text-xs text-[#0F172A] dark:text-[#F8FAFC]">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    <div class="hidden sm:flex items-center gap-1 border-l border-slate-200 dark:border-zinc-800 pl-2">
                        <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors font-medium">Log In</a>
                        <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-lg text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors font-bold">Sign Up</a>
                    </div>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button @click="open = !open" type="button" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none" aria-label="Toggle navigation menu">
                    <span class="text-2xl leading-none">☰</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu (Animated Collapse via Alpine) -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-2" 
             class="md:hidden border-t border-slate-200 dark:border-zinc-800 bg-white/95 dark:bg-[#0B0F19]/95 backdrop-blur-lg px-4 py-4 space-y-2 shadow-lg"
             style="display: none;">
            <a href="{{ route('home') }}" @click="open = false" class="block px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold">Home</a>
            <a href="{{ route('explore') }}" @click="open = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">Explore Quizzes</a>
            <a href="#categories" @click="open = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">Categories</a>
            <a href="{{ route('play.daily') }}" @click="open = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">Daily Challenge</a>
            <a href="{{ route('leaderboard') }}" @click="open = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">Leaderboard</a>
            
            <div class="pt-3 border-t border-slate-200 dark:border-zinc-800 flex flex-col gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2 rounded-xl bg-blue-600 text-white font-bold">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-xl bg-slate-100 dark:bg-zinc-800 text-[#0F172A] dark:text-[#F8FAFC] font-semibold">Log In</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-xl bg-blue-600 text-white font-bold">Create Free Account</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 w-full pt-[68px]">

        <!-- Section A: Hero Section -->
        <div class="relative w-full overflow-hidden">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[980px] h-[360px] bg-gradient-to-tr from-blue-500/15 via-indigo-500/10 to-transparent blur-3xl pointer-events-none -z-10"></div>
            
            <section class="max-w-7xl mx-auto px-4 md:px-8 pt-10 pb-16 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Hero Copy -->
                    <div class="lg:col-span-7 flex flex-col gap-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 self-start shadow-sm text-xs font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-bolt text-amber-500"></i>
                            <span>Live Intel Arena • Season 4</span>
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight leading-[1.1]">
                            Your Next Big Brain Challenge <span class="bg-gradient-to-r from-[#2563EB] via-blue-600 to-indigo-600 bg-clip-text text-transparent">Starts Here.</span>
                        </h1>
                        
                        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                            Test your knowledge, discover new challenges, earn achievements, and see how you rank against other players worldwide.
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="{{ route('play.quick') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold text-base shadow-md hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">
                                <span>Play Now</span>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                            <a href="{{ route('explore') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-[#F8FAFC] font-semibold text-base shadow-sm hover:bg-slate-50 dark:hover:bg-zinc-800 transition-all">
                                <i class="fa-solid fa-compass text-blue-600"></i>
                                <span>Explore Quizzes</span>
                            </a>
                        </div>
                        
                        <!-- Quick Metrics Bar -->
                        <div class="flex items-center gap-6 pt-6 border-t border-slate-200 dark:border-zinc-800">
                            <div>
                                <p class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] dark:text-[#F8FAFC]">1,400+</p>
                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Verified Quizzes</p>
                            </div>
                            <div class="w-px h-8 bg-slate-200 dark:bg-zinc-800"></div>
                            <div>
                                <p class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] dark:text-[#F8FAFC]">240k+</p>
                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Daily Players</p>
                            </div>
                            <div class="w-px h-8 bg-slate-200 dark:bg-zinc-800"></div>
                            <div>
                                <p class="text-2xl sm:text-3xl font-extrabold text-blue-600 dark:text-blue-400">99.4%</p>
                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Fact Precision</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Visual Composition (Interactive Floating Card) -->
                    <div class="lg:col-span-5 relative mt-6 lg:mt-0">
                        <div class="relative bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl p-6 shadow-xl">
                            <!-- Header of Card -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-zinc-800">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                                    <span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                    <span class="text-xs text-slate-500 font-mono ml-2 font-medium">Question 07/10</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-xs font-bold text-blue-600 dark:text-blue-400">12s left</span>
                            </div>

                            <!-- Quiz Question -->
                            <div class="py-4">
                                <span class="text-xs tracking-widest uppercase text-blue-600 dark:text-blue-400 font-bold">Planetary Astronomy</span>
                                <h3 class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC] mt-1">
                                    Which planet has the most officially recognized moons?
                                </h3>
                            </div>

                            <!-- Options -->
                            <div class="flex flex-col gap-2">
                                <div class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-800/60 text-[#0F172A] dark:text-[#F8FAFC] text-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-lg bg-white dark:bg-zinc-700 flex items-center justify-center font-bold text-xs text-slate-500">A</span>
                                        <span>Jupiter</span>
                                    </div>
                                    <i class="fa-regular fa-circle text-slate-400 text-xs"></i>
                                </div>
                                
                                <div class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-900 dark:text-emerald-300 text-sm shadow-sm font-semibold">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">B</span>
                                        <span>Saturn (146 moons)</span>
                                    </div>
                                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                </div>

                                <div class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-800/60 text-[#0F172A] dark:text-[#F8FAFC] text-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-lg bg-white dark:bg-zinc-700 flex items-center justify-center font-bold text-xs text-slate-500">C</span>
                                        <span>Neptune</span>
                                    </div>
                                    <i class="fa-regular fa-circle text-slate-400 text-xs"></i>
                                </div>

                                <div class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-800/60 text-[#0F172A] dark:text-[#F8FAFC] text-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-lg bg-white dark:bg-zinc-700 flex items-center justify-center font-bold text-xs text-slate-500">D</span>
                                        <span>Uranus</span>
                                    </div>
                                    <i class="fa-regular fa-circle text-slate-400 text-xs"></i>
                                </div>
                            </div>

                            <!-- Footer Badges -->
                            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-semibold">Quick Thinker</span>
                                    <span class="px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 font-semibold">Space Trivia</span>
                                </div>
                                <span class="font-medium text-slate-500">91% Accuracy</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Section B: Zero-Friction Quick Play Selector -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-6 w-full">
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 md:p-8 shadow-md">
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    
                    <div class="lg:col-span-5 flex flex-col gap-1.5">
                        <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-wider">
                            <i class="fa-solid fa-bolt"></i>
                            <span>Zero Friction Trivia</span>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F172A] dark:text-[#F8FAFC]">
                            Jump In & Play — Instant Matchmaking!
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Guests play instantly. Scores can be saved anytime to unlock permanent leaderboards.
                        </p>
                    </div>

                    <div class="lg:col-span-7 flex flex-col gap-4">
                        <form action="{{ route('play.quick') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Select Difficulty</label>
                                <select name="difficulty" class="w-full h-11 px-3 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-[#0F172A] dark:text-[#F8FAFC] text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="all">Any Difficulty</option>
                                    <option value="easy">Easy (Friendly)</option>
                                    <option value="medium" selected>Medium (Standard)</option>
                                    <option value="hard">Hard (Mastery)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Choose Domain</label>
                                <select name="category" class="w-full h-11 px-3 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-[#0F172A] dark:text-[#F8FAFC] text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="all">Any Category (Random Mix)</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2 flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Instant round • 10 random questions with timer</span>
                                </div>
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow hover:bg-blue-700 transition-all hover:scale-[1.02]">
                                    <i class="fa-solid fa-play"></i>
                                    <span>Launch Quick Play</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section C: Sponsored Advertisement Slot -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-4 w-full">
            <div class="w-full rounded-2xl bg-slate-100 dark:bg-zinc-900/60 p-2 sm:p-3 flex flex-col items-center justify-center">
                <div class="flex items-center justify-between w-full max-w-4xl px-2 mb-1 text-[10px] text-slate-400 font-mono uppercase tracking-wider">
                    <span>SPONSORED / ADVERTISEMENT</span>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Advertise With Us</a>
                </div>
                <div class="w-full max-w-4xl h-[80px] sm:h-[90px] rounded-xl bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 flex items-center justify-between px-4 sm:px-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-laptop-code text-xl"></i>
                        </div>
                        <div class="text-left">
                            <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-1.5 py-0.5 rounded uppercase">CloudDev Academy</span>
                            <p class="text-sm font-bold text-[#0F172A] dark:text-[#F8FAFC] leading-tight">Level up your technical interviews with simulated code tests.</p>
                            <p class="text-xs text-slate-500 hidden md:block">Over 4,000 real problems from FAANG architectures.</p>
                        </div>
                    </div>
                    <a href="{{ route('explore') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-bold hover:opacity-90">
                        <span>Try Free</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Section D: Trending Quizzes Grid (Responsive grid-cols-1 md:grid-cols-2 lg:grid-cols-3) -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-10 w-full">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-2">
                <div>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold text-xs uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-fire"></i>
                        <span>Community Pulse</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0F172A] dark:text-[#F8FAFC]">Trending Quizzes Right Now</h2>
                </div>
                <a href="{{ route('explore') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    <span>View all trending sets</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($trendingQuizzes as $quiz)
                    <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group hover:-translate-y-1">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                    <i class="{{ $quiz->category->icon ?? 'fa-solid fa-brain' }} text-lg"></i>
                                </div>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold uppercase tracking-wider
                                    {{ $quiz->difficulty === 'easy' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($quiz->difficulty === 'hard' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300') }}">
                                    {{ ucfirst($quiz->difficulty) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC] group-hover:text-blue-600 transition-colors">
                                {{ $quiz->title }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">
                                {{ $quiz->description ?? 'Challenge yourself with this top-rated community quiz!' }}
                            </p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-zinc-800">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-circle-question"></i>
                                    <span>{{ $quiz->questions_count ?? 10 }} Qs</span>
                                    <span>•</span>
                                    <i class="fa-regular fa-clock"></i>
                                    <span>{{ $quiz->time_limit_per_question ? round(($quiz->time_limit_per_question * 10)/60) : 5 }} mins</span>
                                </div>
                                <span class="font-semibold text-blue-600 dark:text-blue-400">{{ number_format($quiz->plays_count) }} plays</span>
                            </div>
                            <a href="{{ route('play.quiz', $quiz->slug ?? $quiz->id) }}" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-zinc-800 text-[#0F172A] dark:text-[#F8FAFC] text-center text-xs font-bold block hover:bg-blue-600 hover:text-white transition-all">
                                Play Quiz
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback Cards if DB is fresh -->
                    <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                                    <i class="fa-solid fa-code text-lg"></i>
                                </div>
                                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold uppercase">Easy</span>
                            </div>
                            <h3 class="text-lg font-bold">JavaScript & Modern Web</h3>
                            <p class="text-xs text-slate-500 mt-1">Closures, event loops, promises, and async patterns.</p>
                        </div>
                        <a href="{{ route('explore') }}" class="mt-4 w-full py-2.5 rounded-xl bg-blue-600 text-white text-center text-xs font-bold block">Play Quiz</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section E: Browse Categories Grid (12 Items) -->
        <section id="categories" class="max-w-7xl mx-auto px-4 md:px-8 py-10 w-full">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-2">
                <div>
                    <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Knowledge Domains</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0F172A] dark:text-[#F8FAFC]">Browse by Category</h2>
                </div>
                <p class="text-xs text-slate-500 max-w-sm">
                    Dive deep into specific disciplines or sharpen cross-functional acumen.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-4 flex flex-col items-center text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="{{ $category->icon ?? 'fa-solid fa-folder' }} text-xl"></i>
                        </div>
                        <h4 class="text-sm font-bold text-[#0F172A] dark:text-[#F8FAFC] group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </h4>
                        <span class="text-xs text-slate-400 mt-1">{{ $category->quizzes_count ?? 12 }} Quizzes</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Section F: Daily Challenge Spotlight Card (Blue Gradient as requested) -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-10 w-full">
            <div class="relative rounded-3xl bg-gradient-to-r from-[#2563EB] via-blue-600 to-indigo-700 text-white border border-blue-400/40 p-6 md:p-10 shadow-xl shadow-blue-500/20 overflow-hidden">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                                <i class="fa-solid fa-trophy text-amber-300"></i>
                                Today's Daily Challenge
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-white/15 text-xs font-semibold text-white border border-white/20">
                                500 Reward Points
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-white/15 text-xs text-blue-100 border border-white/20">
                                15 Questions
                            </span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">
                            {{ $dailyQuiz->title ?? 'Cosmic Astronomy & Space Exploration' }}
                        </h2>
                        
                        <p class="text-sm text-blue-100 max-w-2xl leading-relaxed">
                            {{ $dailyQuiz->description ?? 'Examine deep-sky nebulae, historic telemetry, and orbital mechanics. Complete today’s sprint before the global timer resets to lock your spot in the Hall of Fame.' }}
                        </p>

                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            <a href="{{ route('play.daily') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-[#2563EB] hover:bg-blue-50 font-bold text-sm shadow-lg transition-all hover:scale-[1.02]">
                                <i class="fa-solid fa-play text-amber-500"></i>
                                <span>Play Challenge</span>
                            </a>
                            <div class="flex items-center gap-2 text-xs text-blue-100">
                                <i class="fa-solid fa-users"></i>
                                <span>12,842 contenders completed today</span>
                            </div>
                        </div>
                    </div>

                    <!-- Countdown HUD -->
                    <div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center">
                        <div class="w-full max-w-sm rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 p-6 flex flex-col items-center text-center shadow-lg text-white">
                            <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-amber-300 mb-2 shadow-inner">
                                <i class="fa-solid fa-clock text-2xl"></i>
                            </div>
                            <p class="text-xs uppercase tracking-wider text-blue-100 font-bold">Challenge Closes In</p>
                            <div class="text-3xl font-extrabold font-mono text-white my-1" id="dailyChallengeTimer">
                                08:42:15
                            </div>
                            <p class="text-xs text-blue-200">New challenge drops daily at 00:00 UTC</p>
                            <div class="w-full bg-blue-900/40 mt-4 rounded-full h-2 overflow-hidden border border-white/10">
                                <div class="bg-amber-400 h-2 rounded-full w-2/3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section G: Global Leaderboard Podium -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-10 w-full">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-2">
                <div>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold text-xs uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-medal"></i>
                        <span>Rankings & Prestige</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0F172A] dark:text-[#F8FAFC]">Weekly Global Leaderboard</h2>
                </div>
                <a href="{{ route('leaderboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    <span>View Full Leaderboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Top 3 Podium Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Rank 2: Silver -->
                <div class="order-2 md:order-1 rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col items-center text-center relative">
                    <div class="w-full flex items-center justify-between mb-2">
                        <span class="text-2xl font-black text-slate-400">#2</span>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-slate-300 text-[10px] font-bold uppercase">Silver Tier</span>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-zinc-700 flex items-center justify-center text-xl font-bold my-2 text-slate-700 dark:text-slate-200 border-2 border-slate-400">
                        KJ
                    </div>
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC]">Kenji_99</h4>
                    <p class="text-xs text-slate-500">Tokyo • 94% Accuracy</p>
                    <div class="mt-4 py-2 px-4 rounded-xl bg-slate-50 dark:bg-zinc-800 w-full font-bold text-sm">
                        13,950 pts
                    </div>
                </div>

                <!-- Rank 1: Gold (Center Elevated) -->
                <div class="order-1 md:order-2 rounded-2xl bg-white dark:bg-zinc-900 border-2 border-amber-500/50 p-6 shadow-lg md:-translate-y-3 flex flex-col items-center text-center relative">
                    <div class="w-full flex items-center justify-between mb-2">
                        <span class="text-3xl font-black text-amber-500">#1</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-900 dark:text-amber-300 text-[10px] font-bold uppercase">Champion</span>
                    </div>
                    <div class="w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-2xl font-bold my-2 text-amber-600 border-2 border-amber-500 relative">
                        SV
                        <span class="absolute -top-2 -right-1 text-amber-500 text-lg">👑</span>
                    </div>
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC]">Sarah_Vortex</h4>
                    <p class="text-xs text-slate-500">London • 24 Quiz Streak</p>
                    <div class="mt-4 py-2 px-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-900 dark:text-amber-300 w-full font-extrabold text-base">
                        14,820 pts
                    </div>
                </div>

                <!-- Rank 3: Bronze -->
                <div class="order-3 md:order-3 rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col items-center text-center relative">
                    <div class="w-full flex items-center justify-between mb-2">
                        <span class="text-2xl font-black text-amber-700">#3</span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-900 dark:text-amber-300 text-[10px] font-bold uppercase">Bronze Tier</span>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-zinc-700 flex items-center justify-center text-xl font-bold my-2 text-amber-800 dark:text-amber-400 border-2 border-amber-700">
                        EB
                    </div>
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC]">ElenaBrain</h4>
                    <p class="text-xs text-slate-500">Berlin • 91% Accuracy</p>
                    <div class="mt-4 py-2 px-4 rounded-xl bg-slate-50 dark:bg-zinc-800 w-full font-bold text-sm">
                        12,400 pts
                    </div>
                </div>
            </div>
        </section>

        <!-- Section H: How QuizVerse Works -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-10 w-full">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold text-xs uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Simple, Compelling Gameplay</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#0F172A] dark:text-[#F8FAFC]">How QuizVerse Works</h2>
                <p class="text-sm text-slate-600 dark:text-slate-300 mt-2">
                    Designed for razor-sharp clarity, rapid pacing, and measurable personal improvement.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg mb-4">1</div>
                    <h3 class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC] mb-2">Choose a Challenge</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Select from over a dozen verified categories, try rapid Quick Play, or dive into curated daily challenges.
                    </p>
                </div>

                <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-lg mb-4">2</div>
                    <h3 class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC] mb-2">Answer & Earn Points</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Respond against dynamic countdown timers. Maintain unbroken answer streaks to amplify multiplier rewards and XP.
                    </p>
                </div>

                <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 p-6 shadow-sm flex flex-col">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-[#2563EB] dark:text-[#3B82F6] flex items-center justify-center font-bold text-lg mb-4">3</div>
                    <h3 class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC] mb-2">Track & Compete</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Review detailed accuracy analytics per topic, climb weekly division brackets, and earn verified master badges.
                    </p>
                </div>
            </div>
        </section>

        <!-- Section I: Account Benefits CTA Banner -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 pt-4 pb-16 w-full">
            <div class="rounded-3xl bg-gradient-to-tr from-[#2563EB] via-blue-600 to-indigo-700 text-white p-6 md:p-12 shadow-xl relative overflow-hidden">
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 flex flex-col gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs self-start font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-crown text-amber-300"></i>
                            Unlock Your Complete Trivia Profile
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white">
                            Save Your Progress. Compete Globally. Never Lose a Streak.
                        </h2>
                        <p class="text-blue-100 text-sm sm:text-base max-w-xl">
                            Members preserve complete answer histories, track cognitive performance over time, maintain high-value streak bonuses, and bookmark custom favorite topics.
                        </p>
                    </div>

                    <div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center">
                        <div class="w-full max-w-sm bg-white dark:bg-zinc-900 text-[#0F172A] dark:text-[#F8FAFC] p-6 rounded-2xl shadow-xl flex flex-col gap-3 text-center">
                            <h4 class="text-lg font-bold">Join 240,000+ Players</h4>
                            <p class="text-xs text-slate-500">Takes less than 30 seconds. 100% Free.</p>
                            <a href="{{ route('register') }}" class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold text-sm shadow hover:bg-blue-700 transition-all">
                                Create Your Free Account
                            </a>
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                Already have an account? Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full bg-white dark:bg-zinc-900 border-t border-slate-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs">
                            <i class="fa-solid fa-atom"></i>
                        </div>
                        <span class="text-lg font-bold text-[#0F172A] dark:text-[#F8FAFC]">QuizVerse</span>
                    </div>
                    <p class="text-xs text-slate-500">Play Smart. Challenge Yourself. Have Fun.</p>
                </div>

                <div class="flex flex-col gap-2 text-xs">
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC] uppercase tracking-wider mb-1">Platform</h4>
                    <a href="{{ route('explore') }}" class="text-slate-500 hover:text-blue-600">Explore Quizzes</a>
                    <a href="#categories" class="text-slate-500 hover:text-blue-600">Categories</a>
                    <a href="{{ route('play.daily') }}" class="text-slate-500 hover:text-blue-600">Daily Challenge</a>
                    <a href="{{ route('leaderboard') }}" class="text-slate-500 hover:text-blue-600">Leaderboards</a>
                    <a href="{{ route('play.quick') }}" class="text-slate-500 hover:text-blue-600">Quick Play</a>
                </div>

                <div class="flex flex-col gap-2 text-xs">
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC] uppercase tracking-wider mb-1">Creators & Admins</h4>
                    <a href="{{ route('creator.dashboard') }}" class="text-slate-500 hover:text-blue-600">Creator Studio</a>
                    <a href="{{ route('creator.quizzes.create') }}" class="text-slate-500 hover:text-blue-600">Create a Quiz</a>
                    <a href="{{ route('admin.overview') }}" class="text-slate-500 hover:text-blue-600">Admin Control Plane</a>
                </div>

                <div class="flex flex-col gap-2 text-xs">
                    <h4 class="font-bold text-[#0F172A] dark:text-[#F8FAFC] uppercase tracking-wider mb-1">Evaluation Portals</h4>
                    <a href="{{ route('quick-login', 'player') }}" class="text-blue-600 dark:text-blue-400 font-semibold">1-Click Player Login</a>
                    <a href="{{ route('quick-login', 'creator') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold">1-Click Creator Login</a>
                    <a href="{{ route('quick-login', 'admin') }}" class="text-rose-600 dark:text-rose-400 font-semibold">1-Click Admin Login</a>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>© 2026 QuizVerse Inc. All rights reserved.</p>
                <p>Offline Bundled 2026 Standard • Powered by Laravel & Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <!-- Interactive script for Daily Challenge Timer -->
    <script>
        (function initTimer() {
            const timerElement = document.getElementById('dailyChallengeTimer');
            if (!timerElement) return;
            let totalSeconds = 8 * 3600 + 42 * 60 + 15;
            setInterval(() => {
                if (totalSeconds > 0) totalSeconds--;
                const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                const seconds = String(totalSeconds % 60).padStart(2, '0');
                timerElement.textContent = `${hours}:${minutes}:${seconds}`;
            }, 1000);
        })();
    </script>
</body>
</html>
