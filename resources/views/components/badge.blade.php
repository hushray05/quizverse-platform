@props([
    'variant' => 'blue', // blue, cyan, emerald, amber, rose, zinc, violet
    'size' => 'md', // sm, md, lg
])

@php
$colorClasses = match ($variant) {
    'cyan' => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border-cyan-500/20 shadow-[0_0_12px_rgba(6,182,212,0.15)]',
    'emerald' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20 shadow-[0_0_12px_rgba(16,185,129,0.15)]',
    'amber' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20 shadow-[0_0_12px_rgba(245,158,11,0.15)]',
    'rose' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20 shadow-[0_0_12px_rgba(244,63,94,0.15)]',
    'zinc' => 'bg-slate-100 dark:bg-zinc-800/60 text-slate-700 dark:text-zinc-300 border-slate-200 dark:border-zinc-700/50',
    'violet', 'blue' => 'bg-blue-500/10 text-[#2563EB] dark:text-[#3B82F6] border-blue-500/20 shadow-[0_0_12px_rgba(37,99,235,0.15)]',
    default => 'bg-blue-500/10 text-[#2563EB] dark:text-[#3B82F6] border-blue-500/20 shadow-[0_0_12px_rgba(37,99,235,0.15)]',
};

$sizeClasses = match ($size) {
    'sm' => 'text-[11px] px-2 py-0.5 rounded-full',
    'lg' => 'text-sm px-3.5 py-1.5 rounded-xl',
    default => 'text-xs px-2.5 py-1 rounded-lg',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 font-medium border {$colorClasses} {$sizeClasses} tracking-wide"]) }}>
    {{ $slot }}
</span>
