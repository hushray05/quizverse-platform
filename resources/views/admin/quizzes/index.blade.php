<x-app-layout title="Quiz Management" :breadcrumbs="['Governance' => route('admin.overview'), 'Quizzes' => null]">
    <div class="space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[#0F172A] dark:text-white">Admin Quiz Control Plane</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Configure questions, options, difficulty ratings, and category mappings.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('quiz.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-200 text-xs font-semibold hover:bg-slate-200 dark:hover:bg-zinc-700 transition-colors">
                    <i class="fa-solid fa-gamepad text-blue-600"></i>
                    <span>Frontend Player (/quiz)</span>
                </a>
                <a href="{{ route('admin.quizzes.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>New Quiz</span>
                </a>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="glass-card p-4">
            <form action="{{ route('admin.quizzes.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search quizzes..."
                        class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <select name="category" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="difficulty" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Difficulties</option>
                        <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow">Filter</button>
                    @if(request()->hasAny(['search', 'category', 'difficulty']))
                        <a href="{{ route('admin.quizzes.index') }}" class="py-2 px-3 rounded-xl bg-slate-100 dark:bg-zinc-800 text-slate-500 text-xs hover:bg-slate-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Responsive Quizzes Grid (grid-cols-1 md:grid-cols-2 lg:grid-cols-3) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($quizzes as $quiz)
                <div class="glass-card p-5 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold uppercase tracking-wider
                                {{ $quiz->difficulty === 'easy' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($quiz->difficulty === 'hard' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300') }}">
                                {{ ucfirst($quiz->difficulty) }}
                            </span>

                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                <i class="fa-solid fa-gamepad text-blue-500"></i>
                                <span>{{ number_format($quiz->plays_count) }} plays</span>
                            </div>
                        </div>

                        <!-- Quiz Image or Category Icon -->
                        <div class="w-full h-32 rounded-xl bg-slate-100 dark:bg-zinc-800 overflow-hidden mb-3 flex items-center justify-center border border-slate-200 dark:border-zinc-700">
                            @if($quiz->image)
                                <img src="{{ asset('storage/' . $quiz->image) }}" alt="{{ $quiz->title }}" class="w-full h-auto object-cover max-h-32" />
                            @else
                                <div class="text-center p-4">
                                    <i class="{{ $quiz->category->icon ?? 'fa-solid fa-graduation-cap' }} text-3xl text-blue-500 mb-1"></i>
                                    <p class="text-[11px] font-mono text-slate-400">{{ $quiz->category->name ?? 'Trivia Domain' }}</p>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-[#0F172A] dark:text-white group-hover:text-blue-600 transition-colors">
                            {{ $quiz->title }}
                        </h3>

                        @if($quiz->question)
                            <div class="mt-2 p-2.5 rounded-lg bg-blue-50/50 dark:bg-blue-950/20 border border-blue-500/20 text-xs">
                                <p class="font-semibold text-blue-700 dark:text-blue-300">Question Preview:</p>
                                <p class="text-slate-600 dark:text-zinc-300 line-clamp-2 mt-0.5">{{ $quiz->question }}</p>
                                @if($quiz->correct_answer)
                                    <p class="text-[10px] text-emerald-600 font-mono mt-1">Ans: {{ $quiz->correct_answer }}</p>
                                @endif
                            </div>
                        @else
                            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 line-clamp-2">
                                {{ $quiz->description ?? 'Full multi-question quiz module.' }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-mono">{{ $quiz->questions_count }} Qs • {{ $quiz->time_limit_per_question }}s</span>

                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('quiz.play', $quiz->id) }}" class="px-2.5 py-1 rounded-lg bg-blue-600/10 text-blue-600 hover:bg-blue-600 hover:text-white text-xs font-semibold transition-all" title="Test Play">
                                Play
                            </a>
                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" title="Edit Quiz">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-confirm="Are you sure you want to delete quiz '{{ $quiz->title }}'?" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" title="Delete Quiz">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 text-center py-12 glass-card">
                    <i class="fa-solid fa-circle-question text-4xl text-slate-300 dark:text-zinc-600 mb-2"></i>
                    <p class="text-sm font-bold text-slate-500">No quizzes found.</p>
                    <a href="{{ route('admin.quizzes.create') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold">Create Quiz</a>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $quizzes->links() }}
        </div>
    </div>
</x-app-layout>
