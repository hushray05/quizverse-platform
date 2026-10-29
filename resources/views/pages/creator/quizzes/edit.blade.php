<x-app-layout title="Edit Quiz" :breadcrumbs="['Creator' => route('creator.dashboard'), 'Quizzes' => route('creator.quizzes.index'), 'Edit' => null]">
    <div class="space-y-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Edit Quiz: {{ $quiz->title }}</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Update parameters and attached question syllabus.</p>
            </div>
            <a href="{{ route('play.quiz', $quiz->slug) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 border border-slate-200 dark:border-zinc-700 transition-colors flex items-center gap-1.5">
                <i class="bi bi-play-circle text-[#2563EB] dark:text-[#3B82F6]"></i>
                <span>Preview</span>
            </a>
        </div>

        <div class="glass-card p-6 lg:p-8">
            <form action="{{ route('creator.quizzes.update', $quiz->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Quiz Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Category Domain</label>
                        <select id="category_id" name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $quiz->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Difficulty Profile</label>
                        <select id="difficulty" name="difficulty" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="easy" {{ old('difficulty', $quiz->difficulty) === 'easy' ? 'selected' : '' }}>Easy (Foundational)</option>
                            <option value="medium" {{ old('difficulty', $quiz->difficulty) === 'medium' ? 'selected' : '' }}>Medium (Intermediate)</option>
                            <option value="hard" {{ old('difficulty', $quiz->difficulty) === 'hard' ? 'selected' : '' }}>Hard (Staff / Specialist)</option>
                        </select>
                        @error('difficulty')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="time_limit_per_question" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Time Limit Per Question (seconds)</label>
                        <input type="number" id="time_limit_per_question" name="time_limit_per_question" value="{{ old('time_limit_per_question', $quiz->time_limit_per_question) }}" min="5" max="120" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                        @error('time_limit_per_question')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="xp_reward" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Mastery XP Award</label>
                        <input type="number" id="xp_reward" name="xp_reward" value="{{ old('xp_reward', $quiz->xp_reward) }}" min="10" max="1000" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                        @error('xp_reward')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Description & Trial Syllabus</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]">{{ old('description', $quiz->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $quiz->is_published) ? 'checked' : '' }}
                        class="w-4 h-4 rounded bg-slate-50 dark:bg-zinc-900 border-slate-300 dark:border-zinc-700 text-[#2563EB] focus:ring-0" />
                    <label for="is_published" class="text-xs text-slate-700 dark:text-zinc-300 select-none cursor-pointer">Published to Community Catalog</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-zinc-800">
                    <a href="{{ route('creator.quizzes.index') }}" class="px-4 py-2 rounded-xl text-xs text-slate-500 dark:text-zinc-400 hover:text-[#0F172A] dark:hover:text-white transition-colors">Cancel</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all">
                        Update Configuration
                    </button>
                </div>
            </form>
        </div>

        <!-- Attached Questions Overview -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Attached Questions ({{ $quiz->questions->count() }})</h2>
                <a href="{{ route('creator.questions.create') }}?quiz_id={{ $quiz->id }}" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-bold flex items-center gap-1">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Add Item to Quiz</span>
                </a>
            </div>

            <div class="glass-card divide-y divide-slate-200 dark:divide-zinc-800/80">
                @forelse($quiz->questions as $quest)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-[#0F172A] dark:text-zinc-200">{{ $quest->question_text }}</h4>
                        <p class="text-[10px] text-slate-500 dark:text-zinc-400 font-mono mt-0.5">{{ $quest->points }} pts • {{ $quest->options->count() }} options</p>
                    </div>
                    <a href="{{ route('creator.questions.edit', $quest->id) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white" title="Edit Question">
                        <i class="bi bi-pencil text-xs"></i>
                    </a>
                </div>
                @empty
                <p class="text-xs text-slate-500 dark:text-zinc-500 text-center py-6">No questions currently attached to this quiz.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
