@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'text-[#2563EB] dark:text-[#3B82F6]',
    'class' => '',
])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-[#0B0F19] border border-slate-200/90 dark:border-zinc-800 rounded-2xl p-6 relative overflow-hidden group hover:border-[#2563EB]/40 dark:hover:border-[#3B82F6]/40 shadow-sm transition-all {$class}"]) }}>
    <!-- Subtle top highlight -->
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-blue-500/10 to-transparent"></div>

    @if($title || $icon)
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            @if($icon)
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-zinc-800/80 border border-slate-200 dark:border-zinc-700/50 flex items-center justify-center shadow-inner">
                <i class="{{ $icon }} {{ $iconColor }} text-[18px]"></i>
            </div>
            @endif
            <div>
                @if($title)
                <h3 class="text-base font-bold text-[#0F172A] dark:text-[#F8FAFC] tracking-tight">{{ $title }}</h3>
                @endif
                @if($subtitle)
                <p class="text-xs text-slate-500 dark:text-zinc-400 font-normal">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
        @if(isset($action))
        <div>
            {{ $action }}
        </div>
        @endif
    </div>
    @endif

    {{ $slot }}
</div>
