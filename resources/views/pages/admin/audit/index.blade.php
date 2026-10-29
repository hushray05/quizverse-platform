<x-app-layout title="Audit Security Trails" :breadcrumbs="['Governance' => route('admin.overview'), 'Audit Trails' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Security & Audit Trails</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Immutable forensic event telemetry tracking administrative operations and access logs</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-zinc-400">
                <i class="fa-solid fa-lock text-emerald-500"></i>
                <span>Cryptographic Hash Sealed</span>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="glass-card p-4">
            <form method="GET" action="{{ route('admin.audit.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                        <i class="bi bi-search text-xs"></i>
                    </span>
                    <input type="text" name="action" value="{{ request('action') }}" placeholder="Filter by event action (e.g. user_login, settings_updated)..."
                        class="w-full pl-8 pr-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] font-mono" />
                </div>

                <select name="severity" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                    <option value="">All Severities</option>
                    <option value="info" {{ request('severity') === 'info' ? 'selected' : '' }}>Info</option>
                    <option value="warning" {{ request('severity') === 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="danger" {{ request('severity') === 'danger' ? 'selected' : '' }}>Danger</option>
                    <option value="security" {{ request('severity') === 'security' ? 'selected' : '' }}>Security / Breach</option>
                </select>
            </form>
        </div>

        <!-- Audit Table with Side-Scrolling on Mobile -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-xs min-w-[750px]">
                    <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Severity</th>
                            <th class="py-3 px-4">Action Event</th>
                            <th class="py-3 px-4">Actor</th>
                            <th class="py-3 px-4">Entity</th>
                            <th class="py-3 px-4">IP Address</th>
                            <th class="py-3 px-4">Timestamp</th>
                            <th class="py-3 px-4 text-right">Payload</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                        @foreach($logs as $log)
                        @php
                            $sevVariant = match($log->severity) {
                                'danger', 'security' => 'rose',
                                'warning' => 'amber',
                                default => 'blue',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="py-3.5 px-4">
                                <x-badge :variant="$sevVariant" size="sm">
                                    {{ strtoupper($log->severity) }}
                                </x-badge>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-[#0F172A] dark:text-zinc-100">
                                {{ $log->action }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-[#0F172A] dark:text-zinc-200">{{ $log->user->name ?? 'Automated Kernel' }}</div>
                                <div class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $log->user->email ?? 'System Engine' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-zinc-400 text-[11px]">
                                {{ $log->entity_type ? "{$log->entity_type} #{$log->entity_id}" : 'Global' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-zinc-400 text-[11px]">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-zinc-400 text-[11px]">
                                {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'Recent' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if(!empty($log->details))
                                <button type="button" onclick="Swal.fire({ title: 'Event Payload', html: '<pre class=\'text-left text-xs bg-slate-900 text-blue-300 p-3 rounded-xl font-mono overflow-auto\'>' + JSON.stringify(@json($log->details), null, 2) + '</pre>' })" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-mono font-bold">
                                    JSON
                                </button>
                                @else
                                <span class="text-slate-400 dark:text-zinc-600 font-mono">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
