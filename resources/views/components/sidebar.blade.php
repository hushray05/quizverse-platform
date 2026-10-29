@php
    $user = auth()->user();
@endphp

<aside id="app-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 -translate-x-full md:translate-x-0 md:static md:inset-auto md:z-30 flex-shrink-0 bg-white dark:bg-[#0B0F19] border-r border-slate-200 dark:border-zinc-800 flex flex-col justify-between h-screen select-none transition-transform duration-300 ease-in-out shadow-2xl md:shadow-none">
    <div class="flex flex-col h-full overflow-hidden">
        <!-- Logo / Brand Header -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200 dark:border-zinc-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" title="Return to Homepage">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#2563EB] to-indigo-600 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-atom text-white text-base"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-base font-extrabold tracking-tight text-[#0F172A] dark:text-[#F8FAFC] flex items-center gap-1.5">
                        QuizVerse
                        <span class="text-[9px] px-1.5 py-0.2 rounded font-mono font-semibold bg-blue-500/10 dark:bg-blue-500/20 text-[#2563EB] dark:text-[#3B82F6] border border-blue-500/30">2026</span>
                    </span>
                    <span class="text-[10px] text-slate-400 dark:text-zinc-500 font-mono tracking-wider">NEURAL ENGINE</span>
                </div>
            </a>
            <!-- Mobile close button -->
            <button type="button" onclick="toggleSidebar(false)" class="md:hidden text-slate-400 hover:text-slate-700 dark:text-zinc-400 dark:hover:text-white p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Navigation Sections -->
        <div class="flex-1 overflow-y-auto px-3.5 py-4 space-y-6">
            <!-- Navigation to Homepage & Player Dashboard -->
            <div>
                <p class="px-2.5 text-[10px] font-semibold font-mono tracking-wider text-slate-400 dark:text-zinc-500 uppercase mb-2">Portal Navigation</p>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white">
                        <i class="fa-solid fa-house text-[#2563EB] dark:text-[#3B82F6] text-sm"></i>
                        <span>Public Homepage</span>
                    </a>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-gauge text-blue-500 text-sm"></i>
                        <span>Player Console</span>
                    </a>
                </div>
            </div>

            <!-- Player Arena & Play Section -->
            <div>
                <p class="px-2.5 text-[10px] font-semibold font-mono tracking-wider text-slate-400 dark:text-zinc-500 uppercase mb-2">Arena & Play</p>
                <div class="space-y-1">
                    <a href="{{ route('quiz.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('quiz.*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-gamepad text-[#2563EB] dark:text-[#3B82F6] text-sm"></i>
                        <span>Quiz Player (/quiz)</span>
                        <span class="ml-auto text-[9px] px-1.5 py-0.5 rounded font-mono bg-blue-500/10 text-blue-600 dark:text-blue-400 font-bold">PLAY</span>
                    </a>

                    <a href="{{ route('explore') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('explore*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-compass text-cyan-500 text-sm"></i>
                        <span>Explore Quizzes</span>
                    </a>

                    <a href="{{ route('play.quick') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('play.quick') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-bolt text-amber-500 text-sm"></i>
                        <span>Quick Play Blitz</span>
                        <span class="ml-auto text-[9px] px-1.5 py-0.5 rounded font-mono bg-amber-500/10 text-amber-600 dark:text-amber-400">LIVE</span>
                    </a>

                    <a href="{{ route('play.daily') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('play.daily') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-fire text-orange-500 text-sm"></i>
                        <span>Daily Challenge</span>
                        <span class="ml-auto text-[9px] px-1.5 py-0.5 rounded font-mono bg-orange-500/10 text-orange-600 dark:text-orange-400">2X XP</span>
                    </a>

                    <a href="{{ route('leaderboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('leaderboard') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-trophy text-amber-400 text-sm"></i>
                        <span>Leaderboard</span>
                    </a>

                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('profile*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-user-circle text-emerald-500 text-sm"></i>
                        <span>My Profile</span>
                    </a>
                </div>
            </div>

            <!-- Creator Studio Section -->
            @if($user && ($user->isCreator() || $user->isAdmin()))
            <div>
                <p class="px-2.5 text-[10px] font-semibold font-mono tracking-wider text-slate-400 dark:text-zinc-500 uppercase mb-2">Creator Suite</p>
                <div class="space-y-1">
                    <a href="{{ route('creator.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('creator.dashboard') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-palette text-fuchsia-500 text-sm"></i>
                        <span>Creator Studio</span>
                    </a>

                    <a href="{{ route('creator.quizzes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('creator.quizzes*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-layer-group text-indigo-500 text-sm"></i>
                        <span>Quiz Management</span>
                    </a>

                    <a href="{{ route('creator.questions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('creator.questions.index') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-database text-sky-500 text-sm"></i>
                        <span>Question Bank</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Admin Section -->
            @if($user && $user->isAdmin())
            <div>
                <p class="px-2.5 text-[10px] font-semibold font-mono tracking-wider text-slate-400 dark:text-zinc-500 uppercase mb-2">Governance</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.overview') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.overview') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high text-rose-500 text-sm"></i>
                        <span>Admin Overview</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.categories*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-shapes text-purple-500 text-sm"></i>
                        <span>Categories</span>
                    </a>

                    <a href="{{ route('admin.quizzes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.quizzes*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-graduation-cap text-indigo-500 text-sm"></i>
                        <span>Quizzes</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.users*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-users-gear text-cyan-500 text-sm"></i>
                        <span>User Moderation</span>
                    </a>

                    <a href="{{ route('admin.rbac.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.rbac*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-shield-halved text-amber-500 text-sm"></i>
                        <span>Staff & RBAC</span>
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.analytics*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-chart-line text-emerald-500 text-sm"></i>
                        <span>Platform Analytics</span>
                    </a>

                    <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.campaigns*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-bullhorn text-blue-500 text-sm"></i>
                        <span>Campaigns / Ads</span>
                    </a>

                    <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.audit*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left text-rose-500 text-sm"></i>
                        <span>Audit Security Trails</span>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.settings*') ? 'bg-blue-50 dark:bg-blue-950/40 text-[#2563EB] dark:text-[#3B82F6] font-bold border border-blue-500/20 shadow-sm' : 'text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/60 hover:text-[#2563EB] dark:hover:text-white' }}">
                        <i class="fa-solid fa-sliders text-slate-500 text-sm"></i>
                        <span>Platform Settings</span>
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- User / Session Footer -->
        @if($user)
        <div class="p-3.5 border-t border-slate-200 dark:border-zinc-800 bg-slate-50/60 dark:bg-zinc-900/40">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full border border-blue-500/40 object-cover flex-shrink-0" />
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-[#0F172A] dark:text-zinc-100 truncate">{{ $user->name }}</p>
                        <p class="text-[10px] text-[#2563EB] dark:text-[#3B82F6] font-mono">Lvl {{ $user->level }} • {{ $user->rank_title }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Disconnect Session" class="text-slate-400 hover:text-rose-500 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                    </button>
                </form>
            </div>
            <!-- Streak badge -->
            <div class="flex items-center justify-between text-[11px] px-2 py-1 rounded-lg bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700/50">
                <span class="flex items-center gap-1.5 text-orange-500 font-medium">
                    <i class="fa-solid fa-fire text-xs"></i>
                    <span>{{ $user->streak }} Day Streak</span>
                </span>
                <span class="text-slate-600 dark:text-zinc-300 font-mono font-semibold">{{ number_format($user->xp) }} XP</span>
            </div>
        </div>
        @endif
    </div>
</aside>
