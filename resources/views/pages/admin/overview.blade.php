<x-app-layout title="Admin Overview" :breadcrumbs="['Governance' => null, 'Overview' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-[#2563EB] dark:text-[#3B82F6] text-[11px] font-mono mb-2">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                    <span>MISSION CONTROL</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0F172A] dark:text-white">Platform Governance</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Real-time health telemetry, user trends, and security events.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.analytics.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 border border-slate-200 dark:border-zinc-700/60 transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-line text-emerald-500"></i>
                    <span>Deep Analytics</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 hover:bg-slate-100 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 border border-slate-200 dark:border-zinc-700/60 transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders text-slate-500"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <!-- 4 KPI Metrics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-metric 
                label="Registered Users" 
                :value="$totalUsers" 
                icon="bi bi-people-fill" 
                iconColor="text-[#2563EB] dark:text-[#3B82F6]" 
                iconBg="bg-blue-500/10"
                :change="'+12%'"
                :changePositive="true"
                subtext="Total accounts registered"
            />
            <x-stat-metric 
                label="Catalog Quizzes" 
                :value="$totalQuizzes" 
                icon="fa-solid fa-layer-group" 
                iconColor="text-sky-500" 
                iconBg="bg-sky-500/10"
                subtext="Active technical challenges"
            />
            <x-stat-metric 
                label="Total Trial Runs" 
                :value="number_format($totalAttempts)" 
                icon="bi bi-play-circle-fill" 
                iconColor="text-emerald-500" 
                iconBg="bg-emerald-500/10"
                :change="'+18.5%'"
                :changePositive="true"
                subtext="All-time recorded attempts"
            />
            <x-stat-metric 
                label="Active Campaigns" 
                :value="$activeCampaigns" 
                icon="fa-solid fa-bullhorn" 
                iconColor="text-amber-500" 
                iconBg="bg-amber-500/10"
                subtext="Sponsored ad placements"
            />
        </div>

        <!-- Chart.js 7-Day Activity Trend & Category Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Weekly Activity Chart (2 cols) -->
            <div class="lg:col-span-2 glass-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Platform Trial Volume (Last 7 Days)</h3>
                        <p class="text-xs text-slate-500 dark:text-zinc-400">Daily competitor trial completions across all domains</p>
                    </div>
                    <span class="text-xs font-mono font-semibold text-emerald-500 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Telemetry
                    </span>
                </div>
                <div class="h-64 relative">
                    <canvas id="weeklyActivityChart"></canvas>
                </div>
            </div>

            <!-- Categories Breakdown (1 col) -->
            <div class="glass-card p-6 space-y-4">
                <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Domain Category Distribution</h3>
                <div class="space-y-3">
                    @foreach($categoriesBreakdown as $cat)
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800/80">
                        <div class="flex items-center gap-2.5">
                            <i class="{{ $cat->icon }} text-[#2563EB] dark:text-[#3B82F6] text-sm"></i>
                            <span class="text-xs font-semibold text-[#0F172A] dark:text-zinc-200">{{ $cat->name }}</span>
                        </div>
                        <span class="text-xs font-mono font-bold text-slate-600 dark:text-zinc-400">{{ $cat->quizzes_count }} trials</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Audit Trails & User Registrations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Security Audit Trail -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Security & Governance Trails</h3>
                    <a href="{{ route('admin.audit.index') }}" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-semibold">View All Logs</a>
                </div>

                <div class="glass-card divide-y divide-slate-200 dark:divide-zinc-800/80">
                    @forelse($recentAuditLogs as $log)
                    <div class="p-3.5 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ $log->severity === 'danger' || $log->severity === 'security' ? 'bg-rose-500' : ($log->severity === 'warning' ? 'bg-amber-500' : 'bg-blue-500') }}"></span>
                            <div>
                                <p class="font-mono font-semibold text-[#0F172A] dark:text-zinc-200">{{ $log->action }}</p>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $log->user->name ?? 'System' }} • {{ $log->ip_address }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $log->created_at ? $log->created_at->diffForHumans() : 'Recently' }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 dark:text-zinc-500 text-center py-6">No audit records.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Registrations -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">New Competitor Initializations</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-semibold">User Directory</a>
                </div>

                <div class="glass-card divide-y divide-slate-200 dark:divide-zinc-800/80">
                    @foreach($recentUsers as $u)
                    <div class="p-3.5 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-7 h-7 rounded-full border border-blue-500/30 object-cover" />
                            <div>
                                <p class="font-semibold text-[#0F172A] dark:text-zinc-100">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $u->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-badge :variant="$u->role === 'admin' ? 'rose' : ($u->role === 'creator' ? 'cyan' : 'blue')" size="sm">
                                {{ ucfirst($u->role) }}
                            </x-badge>
                            <div class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono mt-0.5">Lv.{{ $u->level }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyActivityChart');
            if (ctx && window.Chart) {
                new window.Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($trendLabels),
                        datasets: [{
                            label: 'Daily Plays',
                            data: @json($trendData),
                            borderColor: '#2563EB',
                            backgroundColor: 'rgba(37, 99, 235, 0.12)',
                            tension: 0.35,
                            fill: true,
                            pointBackgroundColor: '#3B82F6',
                            pointRadius: 4,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(148, 163, 184, 0.15)' },
                                ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } }
                            },
                            x: {
                                grid: { color: 'transparent' },
                                ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
