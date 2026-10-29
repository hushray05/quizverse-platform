<x-app-layout :title="$category->name" :breadcrumbs="['Console' => route('dashboard'), 'Explore' => route('explore'), $category->name => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Category Banner -->
        <div class="glass-card p-6 lg:p-8 relative overflow-hidden bg-gradient-to-r from-blue-900/20 via-slate-100 dark:via-zinc-900/60 to-white dark:to-zinc-900/40 border-blue-500/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-zinc-900/90 border border-blue-200 dark:border-zinc-700/60 flex items-center justify-center shadow-lg shadow-blue-500/10">
                        <i class="{{ $category->icon }} text-3xl text-[#2563EB] dark:text-[#3B82F6]"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0F172A] dark:text-white">{{ $category->name }}</h1>
                            <x-badge variant="blue" size="sm">Domain Arena</x-badge>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-zinc-300 max-w-xl leading-relaxed">{{ $category->description }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white dark:bg-zinc-900/80 px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-zinc-800 shadow-sm">
                    <div class="text-center">
                        <span class="text-[10px] uppercase font-mono text-slate-500 dark:text-zinc-400 font-semibold">Available Trials</span>
                        <p class="text-lg font-mono font-bold text-[#0F172A] dark:text-white">{{ $category->quizzes_count }}</p>
                    </div>
                    <div class="h-8 w-px bg-slate-200 dark:bg-zinc-800"></div>
                    <div class="text-center">
                        <span class="text-[10px] uppercase font-mono text-slate-500 dark:text-zinc-400 font-semibold">Status</span>
                        <p class="text-xs font-semibold text-emerald-500 flex items-center gap-1 justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quizzes Column (2 cols) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Active Quizzes in {{ $category->name }}</h2>
                    <span class="text-xs text-slate-500 dark:text-zinc-500 font-mono">{{ $quizzes->total() }} total</span>
                </div>

                @if($quizzes->isEmpty())
                    <x-empty-state 
                        icon="fa-solid fa-flask" 
                        iconColor="text-blue-500" 
                        title="No quizzes currently enrolled" 
                        description="This category does not yet contain published trials. Check back soon or create your own."
                        actionLabel="Browse Other Categories"
                        :actionUrl="route('explore')"
                    />
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($quizzes as $quiz)
                            <x-quiz-card :quiz="$quiz" />
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $quizzes->links() }}
                    </div>
                @endif
            </div>

            <!-- Category Top Competitors (1 col) -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Top Competitors in {{ $category->name }}</h2>
                <div class="glass-card p-4 space-y-3">
                    @forelse($categoryLeaders as $index => $leader)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800 hover:border-slate-300 dark:hover:border-zinc-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-lg bg-slate-200 dark:bg-zinc-800 flex items-center justify-center font-mono font-bold text-xs {{ $index === 0 ? 'text-amber-500 bg-amber-500/10 border border-amber-500/30' : 'text-slate-600 dark:text-zinc-400' }}">
                                #{{ $index + 1 }}
                            </span>
                            <img src="{{ $leader->user->avatar_url }}" alt="{{ $leader->user->name }}" class="w-7 h-7 rounded-full border border-blue-500/30 object-cover" />
                            <div>
                                <p class="text-xs font-semibold text-[#0F172A] dark:text-zinc-100 truncate max-w-[120px]">{{ $leader->user->name }}</p>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $leader->attempts_count }} completed</p>
                            </div>
                        </div>
                        <span class="font-mono font-bold text-xs text-[#2563EB] dark:text-[#3B82F6]">{{ number_format($leader->total_score) }} pts</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 dark:text-zinc-500 text-center py-6">No ranked competitors yet in this domain.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
