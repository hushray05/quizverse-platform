@props([
    'quiz',
])

@php
$diffVariant = match($quiz->difficulty) {
    'easy' => 'emerald',
    'hard' => 'rose',
    default => 'amber',
};
@endphp

<div class="bg-white dark:bg-[#0B0F19] border border-slate-200/90 dark:border-zinc-800 rounded-2xl p-5 flex flex-col justify-between group hover:border-[#2563EB]/40 dark:hover:border-[#3B82F6]/40 hover:shadow-lg transition-all duration-300">
    <div>
        <!-- Top bar: Category + Difficulty badge -->
        <div class="flex items-center justify-between mb-3.5">
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-zinc-300 bg-slate-100 dark:bg-zinc-800/80 px-2.5 py-1 rounded-lg border border-slate-200 dark:border-zinc-700/40">
                <i class="{{ $quiz->category->icon }} text-sm text-[#2563EB] dark:text-[#3B82F6]"></i>
                {{ $quiz->category->name }}
            </span>
            <x-badge :variant="$diffVariant" size="sm">
                {{ ucfirst($quiz->difficulty) }}
            </x-badge>
        </div>

        <!-- Title & description -->
        <h3 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] group-hover:text-[#2563EB] dark:group-hover:text-[#3B82F6] transition-colors line-clamp-1 mb-1.5 tracking-tight">
            {{ $quiz->title }}
        </h3>
        <p class="text-xs text-slate-500 dark:text-zinc-400 line-clamp-2 leading-relaxed mb-4">
            {{ $quiz->description ?? 'Interactive high-intensity knowledge trial. Challenge your cognition and earn mastery XP.' }}
        </p>
    </div>

    <div>
        <!-- Metric stats -->
        <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-200 dark:border-zinc-800/80 mb-4 text-center">
            <div>
                <p class="text-[10px] text-slate-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">Questions</p>
                <p class="text-xs font-bold text-[#0F172A] dark:text-[#F8FAFC] font-mono">{{ $quiz->questions_count ?? $quiz->questions->count() }}</p>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">XP Award</p>
                <p class="text-xs font-bold text-[#2563EB] dark:text-[#3B82F6] font-mono">+{{ $quiz->xp_reward }}</p>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">Rating</p>
                <p class="text-xs font-bold text-amber-500 dark:text-amber-400 font-mono">
                    <i class="fa-solid fa-star text-[10px] mr-0.5"></i>{{ number_format($quiz->rating, 1) }}
                </p>
            </div>
        </div>

        <!-- Action CTA -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1 text-[11px] text-slate-500 dark:text-zinc-400">
                <i class="bi bi-people-fill text-slate-400 dark:text-zinc-500"></i>
                <span>{{ number_format($quiz->plays_count) }} plays</span>
            </div>
            <a href="{{ route('play.quiz', $quiz->slug) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-[#2563EB] hover:bg-blue-700 text-white shadow-sm transition-all">
                <span>Play Now</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
