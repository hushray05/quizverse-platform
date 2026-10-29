<x-app-layout title="Edit Quiz" :breadcrumbs="['Governance' => route('admin.overview'), 'Quizzes' => route('admin.quizzes.index'), 'Edit' => null]">
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-[#0F172A] dark:text-white">Edit Quiz: {{ $quiz->title }}</h1>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Update parameters, question prompts, options, and replace local image.</p>
        </div>

        <div class="glass-card p-6 md:p-8">
            <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Meta -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Quiz Title *</label>
                        <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Category Domain *</label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $quiz->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Difficulty *</label>
                        <select name="difficulty" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="easy" {{ old('difficulty', $quiz->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $quiz->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $quiz->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Time Limit (Seconds)</label>
                        <input type="number" name="time_limit_per_question" value="{{ old('time_limit_per_question', $quiz->time_limit_per_question) }}" min="5" max="120"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Upload New Image (Local Storage)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[11px] file:bg-blue-600 file:text-white cursor-pointer" />
                    </div>
                </div>

                <!-- Single Question Setup -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        Question & Options (JSON Structure)
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Question Prompt</label>
                        <textarea name="question" rows="2"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('question', $quiz->question) }}</textarea>
                    </div>

                    @php
                        $opts = is_array($quiz->options) ? $quiz->options : (json_decode($quiz->options, true) ?: []);
                    @endphp

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Multiple Choice Options</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <span class="text-[10px] font-mono text-slate-400">Option 1:</span>
                                <input type="text" name="options[]" value="{{ old('options.0', $opts[0] ?? '') }}"
                                    class="w-full px-3 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-[#0F172A] dark:text-white" />
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400">Option 2:</span>
                                <input type="text" name="options[]" value="{{ old('options.1', $opts[1] ?? '') }}"
                                    class="w-full px-3 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-[#0F172A] dark:text-white" />
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400">Option 3:</span>
                                <input type="text" name="options[]" value="{{ old('options.2', $opts[2] ?? '') }}"
                                    class="w-full px-3 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-[#0F172A] dark:text-white" />
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400">Option 4:</span>
                                <input type="text" name="options[]" value="{{ old('options.3', $opts[3] ?? '') }}"
                                    class="w-full px-3 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-[#0F172A] dark:text-white" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Correct Answer</label>
                        <input type="text" name="correct_answer" value="{{ old('correct_answer', $quiz->correct_answer) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-xs text-emerald-600 dark:text-emerald-400 font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-[#0F172A] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $quiz->description) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-zinc-800">
                    <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2.5 rounded-xl text-xs text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
