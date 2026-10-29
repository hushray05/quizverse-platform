<x-app-layout title="Global Leaderboard" :breadcrumbs="['Console' => route('dashboard'), 'Leaderboard' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Header Banner -->
        <div class="glass-card p-6 lg:p-8 relative overflow-hidden bg-gradient-to-r from-blue-900/20 via-slate-100 dark:via-zinc-900/60 to-white dark:to-zinc-900/40 border-blue-500/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-[#2563EB] dark:text-[#3B82F6] text-[11px] font-mono mb-2">
                        <i class="fa-solid fa-trophy text-amber-500 text-xs"></i>
                        <span>GLOBAL STANDINGS</span>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0F172A] dark:text-[#F8FAFC]">World Championship Ladder</h1>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Real-time competitive standings calculated by XP mastery, accuracy, and streaks.</p>
                </div>

                <div class="flex items-center gap-2 bg-slate-100 dark:bg-zinc-900/80 px-3.5 py-2 rounded-xl border border-slate-200 dark:border-zinc-800 text-xs font-mono text-slate-700 dark:text-zinc-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Season 2026.4 Live</span>
                </div>
            </div>
        </div>

        <!-- Top 3 Podium Cards -->
        @if($globalLeaders->count() >= 3)
        @php
            $topThree = $globalLeaders->take(3);
            $first = $topThree[0];
            $second = $topThree[1];
            $third = $topThree[2];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end pt-4">
            <!-- 2nd Place -->
            <div class="glass-card p-6 text-center border-slate-300 dark:border-zinc-700/60 order-2 md:order-1 hover:scale-105 transition-all">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-mono font-bold bg-slate-200 dark:bg-zinc-700/60 text-slate-700 dark:text-zinc-300 border border-slate-300 dark:border-zinc-600 mb-3">
                    #2 SILVER
                </span>
                <img src="{{ $second->avatar_url }}" alt="{{ $second->name }}" class="w-16 h-16 rounded-full mx-auto border-2 border-slate-400 dark:border-zinc-400 shadow-md object-cover mb-3" />
                <h3 class="text-sm font-bold text-[#0F172A] dark:text-white truncate">{{ $second->name }}</h3>
                <p class="text-[11px] text-slate-500 dark:text-zinc-400 font-mono">{{ $second->rank_title }}</p>
                <div class="mt-4 pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-around text-xs">
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Level</span>
                        <p class="font-bold font-mono text-[#0F172A] dark:text-zinc-200">{{ $second->level }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Mastery XP</span>
                        <p class="font-bold font-mono text-[#2563EB] dark:text-[#3B82F6]">{{ number_format($second->xp) }}</p>
                    </div>
                </div>
            </div>

            <!-- 1st Place Gold -->
            <div class="glass-card p-8 text-center border-amber-500/40 bg-gradient-to-b from-amber-500/10 via-white dark:via-zinc-900/80 to-slate-50 dark:to-zinc-900/90 order-1 md:order-2 shadow-xl shadow-amber-500/10 hover:scale-105 transition-all">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center mx-auto mb-2 text-sm font-bold shadow-md">
                    <i class="fa-solid fa-crown text-amber-100"></i>
                </div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-mono font-bold bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-500/40 mb-3">
                    #1 CHAMPION
                </span>
                <img src="{{ $first->avatar_url }}" alt="{{ $first->name }}" class="w-20 h-20 rounded-full mx-auto border-2 border-amber-400 shadow-xl object-cover mb-3" />
                <h3 class="text-base font-extrabold text-[#0F172A] dark:text-white truncate">{{ $first->name }}</h3>
                <p class="text-xs text-amber-600 dark:text-amber-400 font-mono">{{ $first->rank_title }}</p>
                <div class="mt-5 pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-around text-xs">
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Level</span>
                        <p class="font-bold font-mono text-[#0F172A] dark:text-zinc-100 text-sm">{{ $first->level }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Streak</span>
                        <p class="font-bold font-mono text-orange-500 text-sm flex items-center justify-center gap-1">
                            <i class="fa-solid fa-fire text-xs"></i>{{ $first->streak }}d
                        </p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Mastery XP</span>
                        <p class="font-bold font-mono text-[#2563EB] dark:text-[#3B82F6] text-sm">{{ number_format($first->xp) }}</p>
                    </div>
                </div>
            </div>

            <!-- 3rd Place Bronze -->
            <div class="glass-card p-6 text-center border-amber-700/30 order-3 md:order-3 hover:scale-105 transition-all">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-mono font-bold bg-amber-800/20 text-amber-700 dark:text-amber-500 border border-amber-700/40 mb-3">
                    #3 BRONZE
                </span>
                <img src="{{ $third->avatar_url }}" alt="{{ $third->name }}" class="w-16 h-16 rounded-full mx-auto border-2 border-amber-700 shadow-md object-cover mb-3" />
                <h3 class="text-sm font-bold text-[#0F172A] dark:text-white truncate">{{ $third->name }}</h3>
                <p class="text-[11px] text-slate-500 dark:text-zinc-400 font-mono">{{ $third->rank_title }}</p>
                <div class="mt-4 pt-3 border-t border-slate-200 dark:border-zinc-800 flex justify-around text-xs">
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Level</span>
                        <p class="font-bold font-mono text-[#0F172A] dark:text-zinc-200">{{ $third->level }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono uppercase">Mastery XP</span>
                        <p class="font-bold font-mono text-[#2563EB] dark:text-[#3B82F6]">{{ number_format($third->xp) }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Full Global Table (2 cols) with Mobile Side-Scrolling -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Full Leaderboard Rankings</h2>
                    <span class="text-xs text-slate-500 dark:text-zinc-500 font-mono">{{ $globalLeaders->total() }} competitors ranked</span>
                </div>

                <div class="glass-card overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs min-w-[650px]">
                            <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Rank</th>
                                    <th class="py-3 px-4">Competitor</th>
                                    <th class="py-3 px-4">Title</th>
                                    <th class="py-3 px-4">Level</th>
                                    <th class="py-3 px-4">Streak</th>
                                    <th class="py-3 px-4 text-right">Mastery XP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                @foreach($globalLeaders as $index => $player)
                                @php
                                    $rankNum = ($globalLeaders->currentPage() - 1) * $globalLeaders->perPage() + $index + 1;
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/40 transition-colors {{ auth()->id() === $player->id ? 'bg-blue-50/70 dark:bg-blue-950/20 border-l-4 border-[#2563EB] dark:border-[#3B82F6]' : '' }}">
                                    <td class="py-3.5 px-4 font-mono font-bold">
                                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs {{ $rankNum === 1 ? 'bg-amber-500/20 text-amber-600 dark:text-amber-300 font-extrabold border border-amber-500/30' : ($rankNum === 2 ? 'bg-slate-200 dark:bg-zinc-600/20 text-slate-700 dark:text-zinc-300' : ($rankNum === 3 ? 'bg-amber-800/20 text-amber-700 dark:text-amber-500' : 'text-slate-500 dark:text-zinc-500')) }}">
                                            #{{ $rankNum }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $player->avatar_url }}" alt="{{ $player->name }}" class="w-8 h-8 rounded-full border border-blue-500/30 object-cover flex-shrink-0" />
                                            <div>
                                                <p class="font-semibold text-[#0F172A] dark:text-zinc-100 flex items-center gap-1.5">
                                                    <span>{{ $player->name }}</span>
                                                    @if(auth()->id() === $player->id)
                                                    <span class="text-[9px] px-1.5 py-0.2 rounded font-mono bg-[#2563EB] text-white font-bold">YOU</span>
                                                    @endif
                                                </p>
                                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono truncate max-w-[150px]">{{ $player->bio ?? 'Competitor' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="text-xs text-slate-700 dark:text-zinc-300 font-medium">{{ $player->rank_title }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#0F172A] dark:text-zinc-200">
                                        Lv.{{ $player->level }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-semibold text-orange-500">
                                        <i class="fa-solid fa-fire text-xs mr-0.5"></i>{{ $player->streak }}d
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6] text-right">
                                        {{ number_format($player->xp) }} XP
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $globalLeaders->links() }}
                </div>
            </div>

            <!-- Weekly Top Performers Side Card (1 col) -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Weekly Blitz Leaders (7d)</h2>
                <div class="glass-card p-4 space-y-3">
                    @forelse($weeklyLeaders as $wIndex => $wLeader)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-slate-200 dark:bg-zinc-800 flex items-center justify-center font-mono font-bold text-xs text-amber-500">
                                #{{ $wIndex + 1 }}
                            </span>
                            <img src="{{ $wLeader->user->avatar_url }}" alt="{{ $wLeader->user->name }}" class="w-7 h-7 rounded-full border border-blue-500/30 object-cover" />
                            <div>
                                <p class="text-xs font-semibold text-[#0F172A] dark:text-zinc-100 truncate max-w-[110px]">{{ $wLeader->user->name }}</p>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $wLeader->quizzes_completed }} trials</p>
                            </div>
                        </div>
                        <span class="font-mono font-bold text-xs text-[#2563EB] dark:text-[#3B82F6]">+{{ number_format($wLeader->total_xp) }} XP</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 dark:text-zinc-500 text-center py-6">No weekly sessions completed yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
