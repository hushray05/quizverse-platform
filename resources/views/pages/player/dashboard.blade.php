<x-app-layout title="Player Console" :breadcrumbs="['Console' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Hero Header Bento - Blue Gradient as requested -->
        <div class="relative overflow-hidden rounded-3xl p-6 lg:p-8 bg-gradient-to-r from-[#2563EB] via-blue-600 to-indigo-700 text-white shadow-xl shadow-blue-500/20 border border-blue-400/40">
            <!-- Background glow -->
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl border-2 border-white/50 object-cover shadow-lg" />
                        <span class="absolute -bottom-1.5 -right-1.5 px-1.5 py-0.5 rounded font-mono font-bold text-[9px] bg-slate-900 text-white shadow">
                            Lv.{{ $user->level }}
                        </span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl lg:text-2xl font-bold tracking-tight text-white">{{ $user->name }}</h1>
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-sm">{{ $user->rank_title }}</span>
                        </div>
                        <p class="text-xs text-blue-100 mt-1 flex items-center gap-2">
                            <span>Progress to Level {{ $user->level + 1 }}:</span>
                            <span class="font-mono text-white font-bold">{{ $levelProgress }}%</span>
                        </p>
                        <!-- Level Progress Bar -->
                        <div class="w-48 sm:w-64 h-2.5 bg-blue-900/60 rounded-full overflow-hidden mt-2 border border-blue-300/30">
                            <div class="h-full bg-white rounded-full transition-all duration-500 shadow-sm" style="width: {{ $levelProgress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Instant Action CTAs -->
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <a href="{{ route('play.quick') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-white text-[#2563EB] hover:bg-blue-50 shadow-lg active:scale-[0.98] transition-all">
                        <i class="fa-solid fa-bolt text-amber-500 text-sm"></i>
                        <span>Quick Blitz Play</span>
                    </a>
                    <a href="{{ route('play.daily') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-800/80 hover:bg-blue-800 border border-blue-400/30 text-white transition-all shadow-sm">
                        <i class="fa-solid fa-fire text-amber-300 text-sm"></i>
                        <span>Daily Challenge (2X XP)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 KPI Metrics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-metric 
                label="Total Trials" 
                :value="$totalQuizzesPlayed" 
                icon="fa-solid fa-gamepad" 
                iconColor="text-[#2563EB] dark:text-[#3B82F6]" 
                iconBg="bg-blue-500/10"
                subtext="Recorded gameplay sessions"
            />
            <x-stat-metric 
                label="Accuracy" 
                :value="$avgAccuracy . '%'" 
                icon="bi bi-bullseye" 
                iconColor="text-cyan-500 dark:text-cyan-400" 
                iconBg="bg-cyan-500/10"
                :change="'+2.4%'" 
                :changePositive="true"
                subtext="Overall answer precision"
            />
            <x-stat-metric 
                label="Total Score" 
                :value="number_format($totalScore)" 
                icon="fa-solid fa-star" 
                iconColor="text-amber-500 dark:text-amber-400" 
                iconBg="bg-amber-500/10"
                subtext="Combined performance points"
            />
            <x-stat-metric 
                label="Current Streak" 
                :value="$user->streak . ' Days'" 
                icon="fa-solid fa-fire" 
                iconColor="text-orange-500 dark:text-orange-400" 
                iconBg="bg-orange-500/10"
                subtext="Daily active retention"
            />
        </div>

        <!-- Active Ad Banner (if present) -->
        @if($activeCampaign)
        <div class="glass-card p-5 border-blue-500/30 bg-gradient-to-r from-blue-50 dark:from-blue-950/30 via-white dark:via-zinc-900/60 to-white dark:to-zinc-900/40 relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/40 flex items-center justify-center text-[#2563EB] dark:text-[#3B82F6]">
                    <i class="fa-solid fa-bullhorn text-base"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-blue-500/20 text-[#2563EB] dark:text-blue-300 font-bold border border-blue-500/30">{{ $activeCampaign->badge_text ?? 'FEATURED' }}</span>
                        <h4 class="text-xs font-bold text-[#0F172A] dark:text-white tracking-tight">{{ $activeCampaign->title }}</h4>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">{{ $activeCampaign->content }}</p>
                </div>
            </div>
            <a href="{{ $activeCampaign->target_url }}" target="_blank" rel="noopener" class="px-4 py-1.5 rounded-xl text-xs font-semibold bg-[#2563EB] hover:bg-blue-700 text-white shadow-sm transition-all whitespace-nowrap">
                {{ $activeCampaign->cta_text }}
                <i class="bi bi-box-arrow-up-right ml-1 text-[10px]"></i>
            </a>
        </div>
        @endif

        <!-- Categories Domain Grid -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight">Explore Knowledge Arenas</h2>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Browse categories powered by offline devicon & icon suites</p>
                </div>
                <a href="{{ route('explore') }}" class="text-xs font-semibold text-[#2563EB] dark:text-[#3B82F6] hover:underline flex items-center gap-1">
                    <span>View all</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-3.5">
                @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="glass-card p-4 flex flex-col justify-between group hover:border-[#2563EB]/40 hover:scale-[1.02] transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800/80 border border-slate-200 dark:border-zinc-700/60 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="{{ $cat->icon }} text-xl text-[#2563EB] dark:text-[#3B82F6]"></i>
                        </div>
                        <span class="text-[10px] font-mono text-slate-500 dark:text-zinc-400">{{ $cat->quizzes_count }} trials</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-[#0F172A] dark:text-zinc-200 group-hover:text-[#2563EB] dark:group-hover:text-white transition-colors truncate">{{ $cat->name }}</h4>
                        <p class="text-[11px] text-slate-500 dark:text-zinc-400 line-clamp-1 mt-0.5">{{ $cat->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Featured Quizzes Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight">Featured & Recommended Trials</h2>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">High-yield cognitive tests crafted by platform leads</p>
                </div>
                <a href="{{ route('explore') }}" class="text-xs font-semibold text-[#2563EB] dark:text-[#3B82F6] hover:underline flex items-center gap-1">
                    <span>Explore Catalog</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                @foreach($featuredQuizzes as $quiz)
                    <x-quiz-card :quiz="$quiz" />
                @endforeach
            </div>
        </div>

        <!-- Recent Attempts History -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight">Recent Match Trajectory</h2>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Your latest competitive trials and breakdown summaries</p>
                </div>
                <a href="{{ route('profile.show') }}" class="text-xs font-semibold text-[#2563EB] dark:text-[#3B82F6] hover:underline">
                    View Career
                </a>
            </div>

            @if($recentAttempts->isEmpty())
                <x-empty-state 
                    icon="fa-solid fa-bolt" 
                    iconColor="text-[#2563EB]" 
                    title="No trial history yet" 
                    description="You haven't completed any quiz trials yet. Jump into Quick Blitz or Explore to earn XP."
                    actionLabel="Start Quick Play"
                    :actionUrl="route('play.quick')"
                />
            @else
                <div class="glass-card overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs min-w-[620px]">
                            <thead class="bg-slate-50 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-600 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Trial</th>
                                    <th class="py-3 px-4">Mode</th>
                                    <th class="py-3 px-4">Score</th>
                                    <th class="py-3 px-4">Accuracy</th>
                                    <th class="py-3 px-4">XP Earned</th>
                                    <th class="py-3 px-4">Completed</th>
                                    <th class="py-3 px-4 text-right">Review</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                @foreach($recentAttempts as $attempt)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-[#0F172A] dark:text-zinc-200">
                                        <div class="flex items-center gap-2">
                                            <i class="{{ $attempt->quiz->category->icon ?? 'fa-solid fa-circle-question' }} text-[#2563EB] dark:text-[#3B82F6] text-sm"></i>
                                            <span class="truncate max-w-xs">{{ $attempt->quiz->title ?? 'Blitz Trial' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700/50 uppercase">
                                            {{ $attempt->mode }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-mono font-bold text-[#0F172A] dark:text-white">
                                        {{ number_format($attempt->score) }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center gap-1 font-mono font-semibold {{ $attempt->accuracy_percentage >= 70 ? 'text-emerald-500' : 'text-amber-500' }}">
                                            {{ $attempt->accuracy_percentage }}%
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">
                                        +{{ $attempt->xp_earned }} XP
                                    </td>
                                    <td class="py-3 px-4 text-slate-500 dark:text-zinc-500 font-mono text-[11px]">
                                        {{ $attempt->completed_at ? $attempt->completed_at->diffForHumans() : 'Just now' }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ route('play.results', $attempt->id) }}" class="inline-flex items-center gap-1 text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-medium">
                                            <span>Details</span>
                                            <i class="bi bi-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
