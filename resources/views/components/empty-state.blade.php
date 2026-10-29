@props([
    'icon' => 'fa-solid fa-folder-open',
    'iconColor' => 'text-zinc-600',
    'title' => 'No records found',
    'description' => 'There are no active records matching your criteria.',
    'actionLabel' => null,
    'actionUrl' => null,
])

<div class="glass-card py-16 px-6 text-center border-dashed border-slate-300 dark:border-zinc-800">
    <div class="w-16 h-16 mx-auto mb-4 rounded-3xl bg-slate-100 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 flex items-center justify-center shadow-inner">
        <i class="{{ $icon }} {{ $iconColor }} text-3xl"></i>
    </div>
    <h4 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] mb-1.5">{{ $title }}</h4>
    <p class="text-xs text-slate-500 dark:text-zinc-400 max-w-sm mx-auto mb-6">{{ $description }}</p>

    @if($actionLabel && $actionUrl)
    <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white transition-all shadow-md shadow-blue-500/20">
        <i class="fa-solid fa-plus text-xs"></i>
        {{ $actionLabel }}
    </a>
    @endif
</div>
