<x-gameplay-layout :quiz="$quiz">
    <div id="quiz-arena" class="flex flex-col min-h-screen justify-between p-3 sm:p-6 lg:p-8 max-w-5xl mx-auto w-full overflow-x-hidden">
        <!-- Top HUD Header -->
        <header class="glass-card px-3 sm:px-5 py-2.5 sm:py-3.5 border-slate-200 dark:border-zinc-800 w-full mb-2 sm:mb-4">
            <div class="flex items-center justify-between gap-2.5 w-full">
                <!-- Left: Exit Button + Quiz Title and Mode -->
                <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                    <a href="{{ route('dashboard') }}" data-confirm="Abandon current trial session? Progress will not be registered." class="text-slate-500 hover:text-slate-900 dark:text-zinc-400 dark:hover:text-white p-1.5 sm:p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800/80 transition-colors flex-shrink-0" title="Abandon Trial">
                        <i class="bi bi-x-lg text-xs sm:text-sm"></i>
                    </a>
                    <div class="h-5 sm:h-6 w-px bg-slate-200 dark:bg-zinc-800 flex-shrink-0"></div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <span class="text-[9px] sm:text-[10px] font-mono px-1.5 sm:px-2 py-0.5 rounded bg-blue-500/10 text-[#2563EB] dark:text-[#3B82F6] font-semibold border border-blue-500/20 uppercase whitespace-nowrap flex-shrink-0">
                                {{ $mode }}
                            </span>
                            <h2 class="text-xs sm:text-sm font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight truncate min-w-0" title="{{ $quiz->title }}">{{ $quiz->title }}</h2>
                        </div>
                    </div>
                </div>

                <!-- Right: Progress Indicator + Live Countdown Timer -->
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <!-- Progress count (compact on mobile) -->
                    <div class="text-right flex flex-col items-end justify-center">
                        <p class="text-[9px] sm:text-[10px] uppercase font-mono text-slate-500 dark:text-zinc-400 leading-none hidden sm:block">Progress</p>
                        <p class="text-[11px] sm:text-xs font-mono font-bold text-[#0F172A] dark:text-[#F8FAFC]">
                            <span id="current-q-index">1</span>/<span id="total-q-count">{{ $quiz->questions->count() }}</span>
                        </p>
                    </div>

                    <!-- Live Countdown Timer (Always clearly visible & fully responsive) -->
                    <div class="flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl bg-blue-50/80 dark:bg-zinc-900 border border-blue-200/80 dark:border-zinc-800 shadow-sm flex-shrink-0">
                        <i class="bi bi-stopwatch text-[#2563EB] dark:text-[#3B82F6] text-xs sm:text-sm animate-pulse"></i>
                        <span id="timer-display" class="font-mono font-bold text-xs sm:text-sm text-[#2563EB] dark:text-[#3B82F6] min-w-[28px] sm:w-8 text-center">{{ $quiz->time_limit_per_question }}s</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Progress Stepper Bar -->
        <div class="w-full h-1.5 bg-slate-200 dark:bg-zinc-800 rounded-full overflow-hidden my-3 sm:my-4 border border-slate-200 dark:border-zinc-800">
            <div id="stepper-progress" class="h-full bg-gradient-to-r from-[#2563EB] via-blue-500 to-[#3B82F6] transition-all duration-300" style="width: {{ 100 / max(1, $quiz->questions->count()) }}%"></div>
        </div>

        <!-- Question Viewport Container -->
        <main class="flex-1 flex flex-col justify-center my-4">
            @foreach($quiz->questions as $qIndex => $question)
            <div id="question-card-{{ $qIndex }}" class="question-container {{ $qIndex === 0 ? 'block' : 'hidden' }} space-y-6">
                <!-- Question Header & Text -->
                <div class="glass-card p-6 lg:p-8 border-blue-500/30">
                    <div class="flex items-center justify-between mb-4">
                        <x-badge variant="blue" size="sm">
                            <i class="fa-solid fa-sparkles text-[10px]"></i>
                            <span>{{ $question->points }} Points</span>
                        </x-badge>
                        <span class="text-xs font-mono text-slate-500 dark:text-zinc-400 capitalize">{{ $question->difficulty }} Complexity</span>
                    </div>

                    <h1 class="text-lg lg:text-2xl font-extrabold text-[#0F172A] dark:text-[#F8FAFC] leading-relaxed tracking-tight">
                        {{ $question->question_text }}
                    </h1>
                </div>

                <!-- Answer Options Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    @php $labels = ['A', 'B', 'C', 'D', 'E', 'F']; @endphp
                    @foreach($question->options as $optIndex => $option)
                    <button type="button" 
                        onclick="selectOption({{ $qIndex }}, {{ $question->id }}, {{ $option->id }}, this)"
                        class="option-card-{{ $qIndex }} glass-card p-4 text-left flex items-start gap-3.5 hover:border-blue-500/50 hover:bg-blue-50/50 dark:hover:bg-zinc-800/40 cursor-pointer active:scale-[0.99] transition-all group">
                        
                        <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700/60 flex items-center justify-center font-mono font-bold text-xs text-slate-700 dark:text-zinc-300 group-hover:text-[#2563EB] dark:group-hover:text-white group-hover:border-blue-500/50 flex-shrink-0 transition-colors">
                            {{ $labels[$optIndex] ?? ($optIndex + 1) }}
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-[#0F172A] dark:text-[#F8FAFC] group-hover:text-[#2563EB] dark:group-hover:text-white leading-normal pt-1">
                            {{ $option->option_text }}
                        </span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
        </main>

        <!-- Bottom HUD Controls -->
        <footer class="glass-card px-3 sm:px-5 py-3 sm:py-4 flex items-center justify-between border-slate-200 dark:border-zinc-800 w-full mt-2 sm:mt-4">
            <button type="button" id="prev-btn" onclick="goToPrevQuestion()" class="px-3 sm:px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-zinc-900 hover:bg-slate-200 dark:hover:bg-zinc-800 border border-slate-200 dark:border-zinc-700/60 text-slate-600 dark:text-zinc-400 hover:text-[#0F172A] dark:hover:text-white disabled:opacity-30 disabled:pointer-events-none transition-all flex items-center gap-1.5" disabled>
                <i class="bi bi-chevron-left text-xs"></i>
                <span>Previous</span>
            </button>

            <div class="flex items-center gap-2 text-slate-500 dark:text-zinc-400 text-xs font-mono">
                <i class="bi bi-keyboard text-[#2563EB] dark:text-[#3B82F6]"></i>
                <span class="hidden sm:inline">Press 1-4 to select answer</span>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" id="next-btn" onclick="goToNextQuestion()" class="px-5 py-2 rounded-xl text-xs font-semibold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-[0_0_20px_rgba(37,99,235,0.3)] transition-all flex items-center gap-1.5">
                    <span>Next</span>
                    <i class="bi bi-chevron-right text-xs"></i>
                </button>

                <button type="button" id="submit-btn" onclick="submitTrialForm()" class="hidden px-6 py-2 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-[0_0_25px_rgba(16,185,129,0.35)] transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-flag-checkered text-xs"></i>
                    <span>Submit Trial</span>
                </button>
            </div>
        </footer>

        <!-- Hidden form for trial submission -->
        <form id="submission-form" action="{{ route('play.submit', $quiz->slug) }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="mode" value="{{ $mode }}">
            <div id="hidden-answers-container"></div>
        </form>
    </div>

    @push('scripts')
    <script>
        const totalQuestions = {{ $quiz->questions->count() }};
        const questionTimeLimit = {{ $quiz->time_limit_per_question }};
        let currentQuestion = 0;
        let secondsRemaining = questionTimeLimit;
        let timerInterval = null;
        let questionStartTime = Date.now();

        // Answer storage: { question_id: { selected_option_id: ..., time_taken: ... } }
        const answersState = {};

        function startTimer() {
            clearInterval(timerInterval);
            secondsRemaining = questionTimeLimit;
            questionStartTime = Date.now();
            updateTimerDisplay();

            timerInterval = setInterval(() => {
                secondsRemaining--;
                updateTimerDisplay();

                if (secondsRemaining <= 0) {
                    clearInterval(timerInterval);
                    // Time up on current question -> auto advance or auto submit
                    if (currentQuestion < totalQuestions - 1) {
                        goToNextQuestion();
                    } else {
                        submitTrialForm();
                    }
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const display = document.getElementById('timer-display');
            if (!display) return;
            display.innerText = secondsRemaining + 's';

            if (secondsRemaining <= 5) {
                display.classList.remove('text-[#2563EB]', 'dark:text-[#3B82F6]', 'text-amber-500');
                display.classList.add('text-rose-500', 'animate-pulse');
            } else if (secondsRemaining <= 10) {
                display.classList.remove('text-[#2563EB]', 'dark:text-[#3B82F6]', 'text-rose-500');
                display.classList.add('text-amber-500');
            } else {
                display.classList.remove('text-amber-500', 'text-rose-500');
                display.classList.add('text-[#2563EB]', 'dark:text-[#3B82F6]');
            }
        }

        function selectOption(qIndex, questionId, optionId, cardElement) {
            const timeTaken = Math.round((Date.now() - questionStartTime) / 1000);
            answersState[questionId] = {
                selected_option_id: optionId,
                time_taken: Math.max(1, timeTaken)
            };

            // Reset sibling styles
            document.querySelectorAll(`.option-card-${qIndex}`).forEach(btn => {
                btn.classList.remove('border-[#2563EB]', 'dark:border-[#3B82F6]', 'bg-blue-50', 'dark:bg-blue-900/30', 'ring-2', 'ring-[#2563EB]', 'shadow-md');
            });

            // Active option style
            cardElement.classList.add('border-[#2563EB]', 'dark:border-[#3B82F6]', 'bg-blue-50', 'dark:bg-blue-900/30', 'ring-2', 'ring-[#2563EB]', 'shadow-md');
        }

        function renderQuestion(index) {
            document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(`question-card-${index}`);
            if (target) target.classList.remove('hidden');

            document.getElementById('current-q-index').innerText = index + 1;
            document.getElementById('stepper-progress').style.width = `${((index + 1) / totalQuestions) * 100}%`;

            // Toggle controls
            document.getElementById('prev-btn').disabled = (index === 0);

            if (index === totalQuestions - 1) {
                document.getElementById('next-btn').classList.add('hidden');
                document.getElementById('submit-btn').classList.remove('hidden');
            } else {
                document.getElementById('next-btn').classList.remove('hidden');
                document.getElementById('submit-btn').classList.add('hidden');
            }

            startTimer();
        }

        function goToNextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                currentQuestion++;
                renderQuestion(currentQuestion);
            }
        }

        function goToPrevQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                renderQuestion(currentQuestion);
            }
        }

        function submitTrialForm() {
            clearInterval(timerInterval);
            const container = document.getElementById('hidden-answers-container');
            container.innerHTML = '';

            for (const [qId, data] of Object.entries(answersState)) {
                container.innerHTML += `
                    <input type="hidden" name="answers[${qId}][selected_option_id]" value="${data.selected_option_id}">
                    <input type="hidden" name="answers[${qId}][time_taken]" value="${data.time_taken}">
                `;
            }

            document.getElementById('submission-form').submit();
        }

        // Keyboard hotkeys 1-4 for options
        document.addEventListener('keydown', (e) => {
            const key = parseInt(e.key);
            if (key >= 1 && key <= 6) {
                const currentContainer = document.getElementById(`question-card-${currentQuestion}`);
                if (currentContainer) {
                    const buttons = currentContainer.querySelectorAll('button');
                    if (buttons[key - 1]) {
                        buttons[key - 1].click();
                    }
                }
            } else if (e.key === 'Enter') {
                if (currentQuestion === totalQuestions - 1) {
                    submitTrialForm();
                } else {
                    goToNextQuestion();
                }
            }
        });

        // Initialize first question
        document.addEventListener('DOMContentLoaded', () => {
            renderQuestion(0);
        });
    </script>
    @endpush
</x-gameplay-layout>
