<x-guest-layout title="Join the Arena">
    <div class="w-full max-w-md">
        <!-- Back to Homepage Link -->
        <div class="mb-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563EB] dark:text-[#3B82F6] hover:underline transition-colors">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Return to Homepage</span>
            </a>
        </div>

        <div class="bg-white dark:bg-[#0B0F19] border border-slate-200/90 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
            <div class="text-center mb-6">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-gradient-to-tr from-[#2563EB] to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/25">
                    <i class="fa-solid fa-user-plus text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-[#0F172A] dark:text-[#F8FAFC]">Create QuizVerse Account</h2>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Start climbing the global knowledge leaderboards</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Competitor Handle</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-person text-sm"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border @error('name') border-rose-500 @else border-slate-200 dark:border-zinc-800 @enderror text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" placeholder="NeuralAce" />
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Email Identity</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border @error('email') border-rose-500 @else border-slate-200 dark:border-zinc-800 @enderror text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" placeholder="ace@neural.net" />
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-key text-sm"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border @error('password') border-rose-500 @else border-slate-200 dark:border-zinc-800 @enderror text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" />
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-check2-circle text-sm"></i>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-700 active:scale-[0.98] text-white shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                        <span>Create Account</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-slate-500 dark:text-zinc-400">
                Already registered? 
                <a href="{{ route('login') }}" class="text-[#2563EB] dark:text-[#3B82F6] hover:underline font-bold">Sign In</a>
            </div>
        </div>
    </div>
</x-guest-layout>
