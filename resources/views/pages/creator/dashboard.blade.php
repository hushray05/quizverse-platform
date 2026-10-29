<x-app-layout title="Creator Studio" :breadcrumbs="['Console' => route('dashboard'), 'Creator Studio' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Creator Banner -->
        <div class="glass-card p-6 lg:p-8 relative overflow-hidden bg-gradient-to-r from-blue-900/20 via-slate-100 dark:via-zinc-900/60 to-white dark:to-zinc-900/40 border-blue-500/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-[#2563EB] dark:text-[#3B82F6] text-[11px] font-mono mb-2">
                        <i class="bi bi-palette text-xs"></i>
                        <span>CONTENT AUTHORING WORKBENCH</span>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0F172A] dark:text-white">Creator Studio</h1>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 max-w-xl">
                        Design high-yield questions, assemble custom quizzes, track audience engagement and ratings.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('creator.quizzes.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>New Quiz</span>
                    </a>
                    <a href="{{ route('creator.questions.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 hover:text-[#0F172A] dark:hover:text-white border border-slate-200 dark:border-zinc-700/60 transition-all flex items-center gap-1.5">
                        <i class="bi bi-question-circle text-xs"></i>
                        <span>Add Question</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- KPI Metrics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-metric 
                label="Authored Quizzes" 
                :value="$totalQuizzes" 
                icon="fa-solid fa-layer-group" 
                iconColor="text-[#2563EB] dark:text-[#3B82F6]" 
                iconBg="bg-blue-500/10"
                subtext="Active in library"
            />
            <x-stat-metric 
                label="Question Bank" 
                :value="$totalQuestions" 
                icon="fa-solid fa-database" 
                iconColor="text-sky-500" 
                iconBg="bg-sky-500/10"
                subtext="Engineered items"
            />
            <x-stat-metric 
                label="Total Plays" 
                :value="number_format($totalPlays)" 
                icon="bi bi-play-circle-fill" 
                iconColor="text-emerald-500" 
                iconBg="bg-emerald-500/10"
                subtext="Competitor sessions"
            />
            <x-stat-metric 
                label="Audience Rating" 
                :value="number_format($avgRating, 2)" 
                icon="fa-solid fa-star" 
                iconColor="text-amber-500" 
                iconBg="bg-amber-500/10"
                subtext="Out of 5.00 stars"
            />
        </div>

        <!-- Quizzes & Questions Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Quizzes -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Your Recent Quizzes</h2>
                    <a href="{{ route('creator.quizzes.index') }}" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-semibold">View All</a>
                </div>

                @if($recentQuizzes->isEmpty())
                    <x-empty-state 
                        icon="fa-solid fa-layer-group" 
                        iconColor="text-blue-500" 
                        title="No quizzes authored yet" 
                        description="Assemble your first technical quiz to test the platform competitors."
                        actionLabel="Create Quiz"
                        :actionUrl="route('creator.quizzes.create')"
                    />
                @else
                    <div class="glass-card divide-y divide-slate-200 dark:divide-zinc-800/80">
                        @foreach($recentQuizzes as $q)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-zinc-800/20 transition-colors">
                            <div class="min-w-0 pr-4">
                                <h4 class="text-xs font-bold text-[#0F172A] dark:text-zinc-100 truncate">{{ $q->title }}</h4>
                                <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500 dark:text-zinc-400 font-mono">
                                    <span>{{ $q->category->name }}</span>
                                    <span>•</span>
                                    <span>{{ $q->questions_count }} questions</span>
                                    <span>•</span>
                                    <span class="{{ $q->is_published ? 'text-emerald-500' : 'text-slate-400 dark:text-zinc-500' }} font-semibold">{{ $q->is_published ? 'Published' : 'Draft' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('creator.quizzes.edit', $q->id) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white transition-colors" title="Edit Quiz">
                                <i class="bi bi-pencil-square text-xs"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Questions in Bank -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Recent Question Drafts</h2>
                    <a href="{{ route('creator.questions.index') }}" class="text-xs text-sky-600 dark:text-sky-400 hover:underline font-semibold">View Bank</a>
                </div>

                @if($recentQuestions->isEmpty())
                    <x-empty-state 
                        icon="fa-solid fa-database" 
                        iconColor="text-sky-500" 
                        title="Question Bank is empty" 
                        description="Build individual multiple-choice or true/false question items."
                        actionLabel="Add Question"
                        :actionUrl="route('creator.questions.create')"
                    />
                @else
                    <div class="glass-card divide-y divide-slate-200 dark:divide-zinc-800/80">
                        @foreach($recentQuestions as $quest)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-zinc-800/20 transition-colors">
                            <div class="min-w-0 pr-4">
                                <h4 class="text-xs font-semibold text-[#0F172A] dark:text-zinc-200 line-clamp-1">{{ $quest->question_text }}</h4>
                                <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500 dark:text-zinc-400 font-mono">
                                    <span>{{ $quest->category->name }}</span>
                                    <span>•</span>
                                    <span class="text-[#2563EB] dark:text-[#3B82F6] font-bold">{{ $quest->points }} pts</span>
                                    <span>•</span>
                                    <span class="capitalize">{{ $quest->difficulty }}</span>
                                </div>
                            </div>
                            <a href="{{ route('creator.questions.edit', $quest->id) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white transition-colors" title="Edit Question">
                                <i class="bi bi-pencil-square text-xs"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
