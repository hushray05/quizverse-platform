<x-app-layout title="Platform Analytics" :breadcrumbs="['Governance' => route('admin.overview'), 'Analytics' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Platform Analytics & Intelligence</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Cross-sectional intelligence across question retention, trial velocity, and domain popularity</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-mono text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/30">
                <i class="fa-solid fa-chart-pie text-xs"></i>
                <span>Offline Chart.js Visualizer</span>
            </div>
        </div>

        <!-- 2 Main Graphs Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- 14-Day Play Velocity -->
            <div class="glass-card p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">14-Day Trial Completion Trajectory</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Total player trial sessions completed each 24-hour UTC window</p>
                </div>
                <div class="h-64 relative">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>

            <!-- Domain Popularity Doughnut -->
            <div class="glass-card p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Domain Category Engagement Breakdown</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Relative distribution of trial runs by technical domain</p>
                </div>
                <div class="h-64 relative">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Secondary Breakdown Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Difficulty Spread Bar Chart -->
            <div class="glass-card p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Complexity Distribution</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Available quizzes mapped across difficulty tiers</p>
                </div>
                <div class="h-56 relative">
                    <canvas id="difficultyChart"></canvas>
                </div>
            </div>

            <!-- Competitor Level Tiers -->
            <div class="glass-card p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white tracking-tight">Competitor Skill Tier Distribution</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Active registered players clustered by level progression</p>
                </div>
                <div class="h-56 relative">
                    <canvas id="levelTierChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.Chart) return;

            // 1. Timeline Chart
            new window.Chart(document.getElementById('timelineChart'), {
                type: 'bar',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [{
                        label: 'Completed Runs',
                        data: @json($dailyPlays),
                        backgroundColor: '#2563EB',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(148, 163, 184, 0.15)' },
                            ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } }
                        }
                    }
                }
            });

            // 2. Category Engagement Doughnut
            const catData = @json($categoryData);
            new window.Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: catData.map(c => c.name),
                    datasets: [{
                        data: catData.map(c => Math.max(1, c.plays)),
                        backgroundColor: [
                            '#2563EB', '#06b6d4', '#10b981', '#f59e0b',
                            '#f43f5e', '#3b82f6', '#ec4899', '#6366f1'
                        ],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { color: '#64748b', font: { size: 11, family: 'Inter' } }
                        }
                    }
                }
            });

            // 3. Difficulty Bar Chart
            const diff = @json($difficultyData);
            new window.Chart(document.getElementById('difficultyChart'), {
                type: 'bar',
                data: {
                    labels: ['Easy', 'Medium', 'Hard'],
                    datasets: [{
                        data: [diff.easy, diff.medium, diff.hard],
                        backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'],
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.15)' }, ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } } },
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } } }
                    }
                }
            });

            // 4. Level Tier Bar Chart
            const tiers = @json($levelData);
            new window.Chart(document.getElementById('levelTierChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(tiers),
                    datasets: [{
                        data: Object.values(tiers),
                        backgroundColor: '#06b6d4',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.15)' }, ticks: { color: '#64748b', font: { family: 'monospace', size: 10 } } },
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'monospace', size: 9 } } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
