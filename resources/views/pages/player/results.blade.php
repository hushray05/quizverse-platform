<x-app-layout title="Trial Results Review" :breadcrumbs="['Console' => route('dashboard'), 'Results' => null]">
    <div class="space-y-8 max-w-4xl mx-auto">
        <!-- Results Hero Banner with Royal Blue Gradient -->
        <div class="rounded-3xl p-6 lg:p-10 relative overflow-hidden text-center bg-gradient-to-tr from-[#2563EB] via-blue-600 to-indigo-700 text-white shadow-xl shadow-blue-500/20">
            <!-- Subtle light grid overlay -->
            <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] opacity-15"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-mono mb-4 backdrop-blur-sm">
                    <i class="fa-solid fa-trophy text-amber-300 text-xs"></i>
                    <span class="font-bold tracking-wider">TRIAL EVALUATION PROTOCOL</span>
                </div>

                <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-2">
                    Trial Concluded
                </h1>
                <p class="text-xs text-blue-100 max-w-md mx-auto mb-8 font-sans">
                    {{ $attempt->quiz->title ?? 'Blitz Arena Trial' }} performance metric has been successfully committed to your career record.
                </p>

                <!-- 4 Results Metrics Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 max-w-2xl mx-auto mb-8">
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                        <p class="text-[10px] font-mono text-blue-100 uppercase tracking-wider font-semibold">Final Score</p>
                        <p class="text-2xl font-mono font-bold text-white mt-1">{{ number_format($attempt->score) }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                        <p class="text-[10px] font-mono text-blue-100 uppercase tracking-wider font-semibold">Accuracy</p>
                        <p class="text-2xl font-mono font-bold {{ $attempt->accuracy_percentage >= 70 ? 'text-emerald-300' : 'text-amber-300' }} mt-1">
                            {{ $attempt->accuracy_percentage }}%
                        </p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                        <p class="text-[10px] font-mono text-blue-100 uppercase tracking-wider font-semibold">XP Awarded</p>
                        <p class="text-2xl font-mono font-bold text-amber-300 mt-1">+{{ $attempt->xp_earned }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                        <p class="text-[10px] font-mono text-blue-100 uppercase tracking-wider font-semibold">Max Streak</p>
                        <p class="text-2xl font-mono font-bold text-orange-300 mt-1">{{ $attempt->streak_count }}</p>
                    </div>
                </div>

                <!-- Action CTAs -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('play.quick') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-white text-[#2563EB] hover:bg-blue-50 shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        <span>Play Another Trial</span>
                    </a>
                    <a href="{{ route('leaderboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-white/15 hover:bg-white/25 text-white border border-white/30 backdrop-blur-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-300 text-xs"></i>
                        <span>Global Rankings</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-black/20 hover:bg-black/30 text-blue-100 border border-white/15 backdrop-blur-sm transition-all">
                        Return to Console
                    </a>
                </div>
            </div>
        </div>

        <!-- Question Breakdown Review -->
        @if(!empty($attempt->answers_summary))
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight">Question Analysis & Technical Review</h2>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Step-by-step breakdown of your submissions and architectural explanations</p>
                </div>
                <span class="text-xs font-mono font-semibold text-slate-500 dark:text-zinc-400">{{ count($attempt->answers_summary) }} Questions</span>
            </div>

            <div class="space-y-3.5">
                @foreach($attempt->answers_summary as $idx => $ans)
                <div class="glass-card p-5 border {{ $ans['is_correct'] ? 'border-emerald-500/40 bg-emerald-500/5' : 'border-rose-500/40 bg-rose-500/5' }}">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold {{ $ans['is_correct'] ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-500/30' }}">
                                @if($ans['is_correct'])
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    <i class="bi bi-x-lg"></i>
                                @endif
                            </span>
                            <span class="text-xs font-mono font-semibold text-slate-600 dark:text-zinc-400">Question {{ $idx + 1 }}</span>
                        </div>
                        <span class="font-mono text-xs font-semibold {{ $ans['is_correct'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-zinc-400' }}">
                            +{{ $ans['points_earned'] ?? 0 }} pts • {{ $ans['time_taken'] ?? 0 }}s
                        </span>
                    </div>

                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-[#F8FAFC] mb-3">{{ $ans['question_text'] }}</h3>

                    @if(!empty($ans['explanation']))
                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-zinc-900/80 border border-slate-200 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-400 leading-relaxed font-sans">
                        <span class="font-bold text-[#2563EB] dark:text-[#3B82F6] font-mono mr-1">EXPLANATION:</span>
                        {{ $ans['explanation'] }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
