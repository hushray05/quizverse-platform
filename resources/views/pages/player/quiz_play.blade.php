<x-app-layout :title="'Playing: ' . $quiz->title" :breadcrumbs="['Console' => route('dashboard'), 'Play Arena' => route('quiz.index'), $quiz->title => null]">
    <div class="max-w-3xl mx-auto space-y-6" x-data="quizPlayer()">

        <!-- Quiz Top Header with Live Timer -->
        <div class="glass-card p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 w-full">
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold uppercase tracking-wider
                        {{ $quiz->difficulty === 'easy' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($quiz->difficulty === 'hard' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300') }}">
                        {{ ucfirst($quiz->difficulty) }}
                    </span>
                    <span class="text-xs text-slate-500 font-mono">{{ $quiz->category->name ?? 'General Knowledge' }}</span>
                </div>
                <h1 class="text-lg sm:text-xl font-black text-[#0F172A] dark:text-white truncate" title="{{ $quiz->title }}">{{ $quiz->title }}</h1>
            </div>

            <!-- Countdown Timer Clock -->
            <div class="flex items-center justify-between sm:justify-end gap-3 flex-shrink-0">
                <div class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-blue-50 dark:bg-zinc-800 border border-blue-200 dark:border-zinc-700 flex items-center gap-2">
                    <i class="fa-solid fa-stopwatch text-blue-600 dark:text-blue-400 text-base sm:text-lg" :class="{ 'animate-pulse text-rose-500': timeLeft <= 5 }"></i>
                    <span class="text-base sm:text-lg font-bold font-mono text-[#0F172A] dark:text-white" x-text="timeLeft + 's'">{{ $quiz->time_limit_per_question ?? 20 }}s</span>
                </div>
            </div>
        </div>

        @php
            $displayQuestion = $quiz->question;
            $displayOptions = [];

            if (!empty($quiz->options)) {
                $displayOptions = is_array($quiz->options) ? $quiz->options : json_decode($quiz->options, true);
            }

            // Fallback to related questions if single question fields are empty
            if (empty($displayQuestion) && $quiz->questions->isNotEmpty()) {
                $firstQ = $quiz->questions->first();
                $displayQuestion = $firstQ->question_text;
                $displayOptions = $firstQ->options->pluck('option_text')->toArray();
            }
        @endphp

        <!-- Question Card -->
        <div class="glass-card p-6 md:p-8 space-y-6">
            <div>
                <span class="text-xs font-mono font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-widest">Active Question</span>
                <h2 class="text-xl md:text-2xl font-bold text-[#0F172A] dark:text-white mt-1 leading-snug">
                    {{ $displayQuestion ?: 'What is the primary architectural concept demonstrated by this quiz set?' }}
                </h2>
            </div>

            <!-- Multiple Choice Options -->
            <div class="grid grid-cols-1 gap-3">
                @if(!empty($displayOptions))
                    @foreach($displayOptions as $idx => $opt)
                        @php $letter = chr(65 + $idx); @endphp
                        <button type="button" 
                                @click="selectOption('{{ addslashes($opt) }}')"
                                :class="{
                                    'border-blue-600 bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 ring-2 ring-blue-500': selectedOption === '{{ addslashes($opt) }}',
                                    'border-slate-200 dark:border-zinc-800 bg-slate-50/60 dark:bg-zinc-900/60 text-[#0F172A] dark:text-zinc-200 hover:border-slate-300 dark:hover:border-zinc-700': selectedOption !== '{{ addslashes($opt) }}'
                                }"
                                class="w-full text-left p-4 rounded-xl border flex items-center justify-between transition-all hover:scale-[1.01]">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-lg bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 flex items-center justify-center font-bold text-xs"
                                      :class="{ 'bg-blue-600 text-white border-blue-600': selectedOption === '{{ addslashes($opt) }}' }">
                                    {{ $letter }}
                                </span>
                                <span class="text-sm font-medium">{{ $opt }}</span>
                            </div>
                            <i class="fa-solid fa-check text-blue-600 text-sm" x-show="selectedOption === '{{ addslashes($opt) }}'" style="display: none;"></i>
                        </button>
                    @endforeach
                @else
                    <!-- Fallback demo choices -->
                    <button type="button" @click="selectOption('Option A')" class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-zinc-800 text-sm">A. Comprehensive Framework Architecture</button>
                    <button type="button" @click="selectOption('Option B')" class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-zinc-800 text-sm">B. Component Lifecycle Management</button>
                @endif
            </div>

            <!-- Submit Action -->
            <div class="pt-4 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Select an answer and click Submit</span>
                
                <button type="button" 
                        @click="submitQuiz()" 
                        :disabled="!selectedOption || isSubmitting"
                        class="px-6 py-2.5 rounded-xl bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 disabled:opacity-50 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all">
                    <span x-text="isSubmitting ? 'Evaluating...' : 'Lock In Answer'">Lock In Answer</span>
                </button>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function quizPlayer() {
            return {
                timeLeft: {{ $quiz->time_limit_per_question ?? 20 }},
                selectedOption: null,
                isSubmitting: false,
                timerInterval: null,

                init() {
                    this.timerInterval = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            clearInterval(this.timerInterval);
                            this.timeUp();
                        }
                    }, 1000);
                },

                selectOption(opt) {
                    this.selectedOption = opt;
                },

                timeUp() {
                    window.Swal.fire({
                        title: 'Time Elapsed!',
                        text: 'The countdown has expired for this question trial.',
                        icon: 'warning',
                        confirmButtonText: 'Review Next Trial',
                        confirmButtonColor: '#2563EB',
                    }).then(() => {
                        window.location.href = "{{ route('quiz.index') }}";
                    });
                },

                submitQuiz() {
                    if (!this.selectedOption) return;
                    clearInterval(this.timerInterval);
                    this.isSubmitting = true;

                    fetch("{{ route('quiz.submit', $quiz) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            selected_answer: this.selectedOption
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isSubmitting = false;
                        window.Swal.fire({
                            title: data.is_correct ? 'Correct! + ' + data.points_earned + ' XP' : 'Incorrect',
                            text: data.feedback + (data.correct_answer ? ' (Correct Answer: ' + data.correct_answer + ')' : ''),
                            icon: data.is_correct ? 'success' : 'error',
                            confirmButtonText: 'Play More Quizzes',
                            confirmButtonColor: '#2563EB',
                        }).then(() => {
                            window.location.href = "{{ route('quiz.index') }}";
                        });
                    })
                    .catch(err => {
                        this.isSubmitting = false;
                        window.notify('error', 'Error submitting answer. Try again.');
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
