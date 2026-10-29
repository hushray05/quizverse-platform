@props([
    'label',
    'value',
    'icon',
    'iconColor' => 'text-[#2563EB] dark:text-[#3B82F6]',
    'iconBg' => 'bg-blue-500/10',
    'change' => null,
    'changePositive' => true,
    'subtext' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-[#0B0F19] border border-slate-200/90 dark:border-zinc-800 rounded-2xl p-5 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow']) }}>
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-zinc-400 mb-1.5">{{ $label }}</p>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl lg:text-3xl font-extrabold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight font-mono">{{ $value }}</span>
                @if($change)
                <span class="inline-flex items-center text-xs font-semibold {{ $changePositive ? 'text-emerald-500' : 'text-rose-500' }}">
                    <i class="bi {{ $changePositive ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }} mr-0.5"></i>
                    {{ $change }}
                </span>
                @endif
            </div>
            @if($subtext)
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">{{ $subtext }}</p>
            @endif
        </div>
        <div class="w-11 h-11 rounded-2xl {{ $iconBg }} border border-slate-200/60 dark:border-white/5 flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-sm">
            <i class="{{ $icon }} {{ $iconColor }} text-[20px]"></i>
        </div>
    </div>
</div>
