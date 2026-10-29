<x-app-layout title="Quiz Arena" :breadcrumbs="['Console' => route('dashboard'), 'Play Arena' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">

        <!-- Top Header & Banner with Royal Blue Gradient -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-tr from-[#2563EB] via-blue-600 to-indigo-700 text-white p-6 md:p-8 shadow-xl shadow-blue-500/20">
            <!-- Subtle light grid overlay -->
            <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] opacity-15"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                        <i class="fa-solid fa-gamepad text-amber-300"></i>
                        <span>Frontend Quiz Arena (/quiz)</span>
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Select a Challenge to Play</h1>
                    <p class="text-xs md:text-sm text-blue-100 max-w-xl">Browse verified quizzes, test your knowledge against dynamic countdowns, and climb the leaderboard.</p>
                </div>

                <a href="{{ route('play.quick') }}" class="px-5 py-2.5 rounded-xl bg-white text-[#2563EB] font-bold text-xs shadow-md hover:bg-blue-50 transition-all hover:scale-105 whitespace-nowrap">
                    <i class="fa-solid fa-bolt text-amber-500 mr-1.5"></i>
                    <span>Quick Play Match</span>
                </a>
            </div>
        </div>

        <!-- Quizzes Grid (Responsive grid-cols-1 md:grid-cols-2 lg:grid-cols-3) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
                <div class="glass-card p-5 flex flex-col justify-between group hover:-translate-y-1 transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold uppercase tracking-wider
                                {{ $quiz->difficulty === 'easy' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($quiz->difficulty === 'hard' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300') }}">
                                {{ ucfirst($quiz->difficulty) }}
                            </span>

                            <span class="text-xs text-slate-500 dark:text-zinc-400 font-mono">{{ number_format($quiz->plays_count) }} plays</span>
                        </div>

                        <!-- Quiz Image or Category Icon -->
                        <div class="w-full h-36 rounded-xl bg-slate-100 dark:bg-zinc-800/80 overflow-hidden mb-3 flex items-center justify-center border border-slate-200 dark:border-zinc-700">
                            @if($quiz->image)
                                <img src="{{ asset('storage/' . $quiz->image) }}" alt="{{ $quiz->title }}" class="w-full h-auto object-cover max-h-36" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-center p-4\'><i class=\'fa-solid fa-brain text-4xl text-[#2563EB] mb-1\'></i></div>';" />
                            @else
                                <div class="text-center p-4">
                                    <i class="{{ $quiz->category->icon ?? 'fa-solid fa-brain' }} text-4xl text-[#2563EB] dark:text-[#3B82F6] mb-1"></i>
                                    <p class="text-xs font-mono text-slate-500 dark:text-zinc-400">{{ $quiz->category->name ?? 'Trivia Domain' }}</p>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-[#0F172A] dark:text-white group-hover:text-[#2563EB] dark:group-hover:text-[#3B82F6] transition-colors">
                            {{ $quiz->title }}
                        </h3>

                        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 line-clamp-2">
                            {{ $quiz->description ?? ($quiz->question ? 'Direct question trial: ' . Str::limit($quiz->question, 60) : 'Test your domain expertise.') }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-zinc-800 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-zinc-400">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $quiz->time_limit_per_question ?? 20 }}s limit</span>
                        </div>

                        <a href="{{ route('quiz.play', $quiz->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all hover:scale-105">
                            <span>Play Now</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $quizzes->links() }}
        </div>
    </div>
</x-app-layout>
