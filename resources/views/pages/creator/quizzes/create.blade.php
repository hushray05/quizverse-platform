<x-app-layout title="Create Quiz" :breadcrumbs="['Creator' => route('creator.dashboard'), 'Quizzes' => route('creator.quizzes.index'), 'New Quiz' => null]">
    <div class="space-y-6 max-w-3xl mx-auto">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Assemble New Quiz Trial</h1>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Configure foundational parameters, pacing rules, and reward values.</p>
        </div>

        <div class="glass-card p-6 lg:p-8">
            <form action="{{ route('creator.quizzes.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Quiz Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required autofocus
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" placeholder="e.g. Distributed Transactions & Raft Consensus" />
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Category Domain</label>
                        <select id="category_id" name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="">Select Domain...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Difficulty Profile</label>
                        <select id="difficulty" name="difficulty" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Easy (Foundational)</option>
                            <option value="medium" {{ old('difficulty', 'medium') === 'medium' ? 'selected' : '' }}>Medium (Intermediate)</option>
                            <option value="hard" {{ old('difficulty') === 'hard' ? 'selected' : '' }}>Hard (Staff / Specialist)</option>
                        </select>
                        @error('difficulty')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="time_limit_per_question" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Time Limit Per Question (seconds)</label>
                        <input type="number" id="time_limit_per_question" name="time_limit_per_question" value="{{ old('time_limit_per_question', 20) }}" min="5" max="120" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                        @error('time_limit_per_question')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="xp_reward" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Mastery XP Award</label>
                        <input type="number" id="xp_reward" name="xp_reward" value="{{ old('xp_reward', 150) }}" min="10" max="1000" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                        @error('xp_reward')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Description & Trial Syllabus</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]" placeholder="Provide competitors context on the technical depth and concepts tested...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded bg-slate-50 dark:bg-zinc-900 border-slate-300 dark:border-zinc-700 text-[#2563EB] focus:ring-0" />
                    <label for="is_published" class="text-xs text-slate-700 dark:text-zinc-300 select-none cursor-pointer">Publish immediately to Explore Catalog</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-zinc-800">
                    <a href="{{ route('creator.quizzes.index') }}" class="px-4 py-2 rounded-xl text-xs text-slate-500 dark:text-zinc-400 hover:text-[#0F172A] dark:hover:text-white transition-colors">Cancel</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all">
                        Initialize Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
