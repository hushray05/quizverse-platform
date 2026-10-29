<x-guest-layout title="Authentication">
    <div class="w-full max-w-md">
        <!-- Back to Homepage Link -->
        <div class="mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563EB] dark:text-[#3B82F6] hover:underline transition-colors">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Return to Homepage</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="bg-white dark:bg-[#0B0F19] border border-slate-200/90 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-gradient-to-tr from-[#2563EB] to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/25">
                    <i class="fa-solid fa-fingerprint text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-[#0F172A] dark:text-[#F8FAFC]">Sign In to QuizVerse</h2>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Authenticate into the competitive knowledge engine</p>
            </div>

            <!-- Instant Demo Logins (1-Click) Moved From Header -->
            <div class="mb-6 p-4 rounded-2xl bg-slate-50 dark:bg-zinc-900/80 border border-slate-200 dark:border-zinc-800">
                <div class="flex items-center justify-between mb-2.5">
                    <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-bolt text-amber-500 text-xs"></i>
                        <span>Live Demo Credentials</span>
                    </p>
                    <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/40 text-[#2563EB] dark:text-[#3B82F6] font-semibold">1-Click</span>
                </div>
                
                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('quick-login', 'player') }}" class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-100 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-900/60 text-center transition-all group" title="player@quizverse.com / password">
                        <div class="text-[11px] font-bold text-[#2563EB] dark:text-[#3B82F6]">Player</div>
                        <div class="text-[9px] text-slate-500 dark:text-zinc-400 font-mono mt-0.5">Quick Login</div>
                    </a>
                    <a href="{{ route('quick-login', 'creator') }}" class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 border border-emerald-200 dark:border-emerald-900/60 text-center transition-all group" title="creator@quizverse.com / password">
                        <div class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Creator</div>
                        <div class="text-[9px] text-slate-500 dark:text-zinc-400 font-mono mt-0.5">Quick Login</div>
                    </a>
                    <a href="{{ route('quick-login', 'admin') }}" class="p-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/40 border border-rose-200 dark:border-rose-900/60 text-center transition-all group" title="admin@quizverse.com / password">
                        <div class="text-[11px] font-bold text-rose-600 dark:text-rose-400">Admin</div>
                        <div class="text-[9px] text-slate-500 dark:text-zinc-400 font-mono mt-0.5">Quick Login</div>
                    </a>
                </div>
                
                <div class="mt-2.5 pt-2 border-t border-slate-200/80 dark:border-zinc-800 text-[10px] text-slate-500 dark:text-zinc-400 font-mono flex items-center justify-between">
                    <span>Default Password:</span>
                    <span class="font-bold text-slate-700 dark:text-zinc-300">password</span>
                </div>
            </div>

            <div class="relative flex py-2 items-center mb-6">
                <div class="flex-grow border-t border-slate-200 dark:border-zinc-800"></div>
                <span class="flex-shrink mx-3 text-[11px] text-slate-400 dark:text-zinc-500 font-mono">or manual credential</span>
                <div class="flex-grow border-t border-slate-200 dark:border-zinc-800"></div>
            </div>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'player@quizverse.com') }}" required autofocus
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border @error('email') border-rose-500 @else border-slate-200 dark:border-zinc-800 @enderror text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" />
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-key text-sm"></i>
                        </span>
                        <input type="password" id="password" name="password" value="password" required
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border @error('password') border-rose-500 @else border-slate-200 dark:border-zinc-800 @enderror text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" />
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-zinc-400 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-50 dark:bg-zinc-900 border-slate-300 dark:border-zinc-700 text-[#2563EB] focus:ring-0 focus:ring-offset-0" />
                        <span>Preserve session</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-700 active:scale-[0.98] text-white shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-slate-500 dark:text-zinc-400">
                New competitor? 
                <a href="{{ route('register') }}" class="text-[#2563EB] dark:text-[#3B82F6] hover:underline font-bold">Create Account</a>
            </div>
        </div>
    </div>
</x-guest-layout>
