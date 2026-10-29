<x-app-layout :title="$question ? 'Edit Question' : 'Question Engineer Workbench'" :breadcrumbs="['Creator' => route('creator.dashboard'), 'Questions' => route('creator.questions.index'), ($question ? 'Edit' : 'Editor') => null]">
    <div class="space-y-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">{{ $question ? 'Edit Question' : 'Question Engineer Workbench' }}</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Design precision questions with verifiable technical answers and automated explanation payloads.</p>
            </div>
            <a href="{{ route('creator.questions.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#0F172A] dark:hover:text-white border border-slate-200 dark:border-zinc-700 transition-colors">
                Back to Bank
            </a>
        </div>

        <div class="glass-card p-6 lg:p-8">
            <form action="{{ $question ? route('creator.questions.update', $question->id) : route('creator.questions.store') }}" method="POST" class="space-y-6">
                @csrf
                @if($question)
                    @method('PUT')
                @endif

                <!-- Question Prompt -->
                <div>
                    <label for="question_text" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Question Prompt Text</label>
                    <textarea id="question_text" name="question_text" rows="3" required autofocus
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-sans" placeholder="State your technical scenario or conceptual problem clearly...">{{ old('question_text', $question->question_text ?? '') }}</textarea>
                    @error('question_text')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category, Quiz, Difficulty, Points Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Domain Category</label>
                        <select id="category_id" name="category_id" required class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="">Select Domain...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $question->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quiz_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Attach to Quiz (Optional)</label>
                        <select id="quiz_id" name="quiz_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="">— Unassigned Item —</option>
                            @foreach($quizzes as $q)
                                <option value="{{ $q->id }}" {{ old('quiz_id', $question->quiz_id ?? request('quiz_id')) == $q->id ? 'selected' : '' }}>{{ $q->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="difficulty" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Complexity Level</label>
                        <select id="difficulty" name="difficulty" required class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono">
                            <option value="easy" {{ old('difficulty', $question->difficulty ?? '') === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $question->difficulty ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $question->difficulty ?? '') === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>

                    <div>
                        <label for="points" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Points Value</label>
                        <input type="number" id="points" name="points" value="{{ old('points', $question->points ?? 25) }}" min="5" max="100" required
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-mono" />
                    </div>
                </div>

                <!-- Answer Options Matrix -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-[#0F172A] dark:text-zinc-300 font-mono">Options Configuration</h3>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-500">Provide candidate answers and mark exactly one radio button as the correct resolution.</p>
                        </div>
                        <button type="button" onclick="addOptionRow()" class="px-3 py-1 rounded-lg text-xs font-semibold bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-[#2563EB] dark:text-[#3B82F6] border border-slate-200 dark:border-zinc-700 transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Add Row</span>
                        </button>
                    </div>

                    <div id="options-container" class="space-y-2.5">
                        @php
                            $existingOptions = $question ? $question->options : collect();
                            $optCount = max(2, $existingOptions->count());
                        @endphp

                        @for($i = 0; $i < $optCount; $i++)
                        @php
                            $optText = $existingOptions[$i]->option_text ?? '';
                            $isCorrect = $existingOptions[$i]->is_correct ?? ($i === 0);
                        @endphp
                        <div class="option-row flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-900/90 border border-slate-200 dark:border-zinc-800">
                            <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
                                <input type="radio" name="correct_option_index" value="{{ $i }}" {{ $isCorrect ? 'checked' : '' }}
                                    class="w-4 h-4 text-emerald-500 bg-white dark:bg-zinc-800 border-slate-300 dark:border-zinc-700 focus:ring-0" />
                                <span class="text-[11px] font-mono font-bold text-emerald-600 dark:text-emerald-400">CORRECT</span>
                            </label>
                            <input type="text" name="options[]" value="{{ old("options.{$i}", $optText) }}" required
                                class="flex-1 px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-950 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-sans" placeholder="Enter option text..." />
                            <button type="button" onclick="removeOptionRow(this)" class="text-slate-400 hover:text-rose-500 p-1 rounded transition-colors" title="Remove option">
                                <i class="bi bi-x-lg text-xs"></i>
                            </button>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Explanation Payload -->
                <div>
                    <label for="explanation" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Technical Explanation & Knowledge Citation</label>
                    <textarea id="explanation" name="explanation" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] font-sans" placeholder="Explaining WHY this answer is correct, citing standards, RFCs, or conceptual logic for competitors during review...">{{ old('explanation', $question->explanation ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-zinc-800">
                    <a href="{{ route('creator.questions.index') }}" class="px-4 py-2 rounded-xl text-xs text-slate-500 dark:text-zinc-400 hover:text-[#0F172A] dark:hover:text-white transition-colors">Cancel</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all">
                        {{ $question ? 'Synchronize Question' : 'Commit to Question Bank' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function addOptionRow() {
            const container = document.getElementById('options-container');
            const index = container.querySelectorAll('.option-row').length;
            if (index >= 6) {
                window.notify('warning', 'Maximum of 6 options permitted per question.');
                return;
            }

            const div = document.createElement('div');
            div.className = 'option-row flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-900/90 border border-slate-200 dark:border-zinc-800';
            div.innerHTML = `
                <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
                    <input type="radio" name="correct_option_index" value="${index}" class="w-4 h-4 text-emerald-500 bg-white dark:bg-zinc-800 border-slate-300 dark:border-zinc-700 focus:ring-0" />
                    <span class="text-[11px] font-mono font-bold text-emerald-600 dark:text-emerald-400">CORRECT</span>
                </label>
                <input type="text" name="options[]" required class="flex-1 px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-950 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-sans" placeholder="Enter option text..." />
                <button type="button" onclick="removeOptionRow(this)" class="text-slate-400 hover:text-rose-500 p-1 rounded transition-colors" title="Remove option">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function removeOptionRow(btn) {
            const rows = document.querySelectorAll('.option-row');
            if (rows.length <= 2) {
                window.notify('warning', 'A question must feature at least 2 options.');
                return;
            }
            btn.closest('.option-row').remove();
            // Re-index radio values
            document.querySelectorAll('.option-row input[type="radio"]').forEach((radio, idx) => {
                radio.value = idx;
            });
        }
    </script>
    @endpush
</x-app-layout>
