<x-app-layout title="Ad & Campaign Management" :breadcrumbs="['Governance' => route('admin.overview'), 'Campaigns' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Campaign & Sponsored Placement Controls</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Configure verified sponsor announcements, custom badges, target URLs, and CTR telemetry</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Create Campaign Form (1 col) -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Deploy Placement</h2>
                <div class="glass-card p-6">
                    <form action="{{ route('admin.campaigns.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Campaign Headline</label>
                            <input type="text" id="title" name="title" required
                                class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] font-mono" placeholder="DevPulse 2026 AI Summit" />
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="type" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Placement Type</label>
                                <select id="type" name="type" required class="w-full px-2.5 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]">
                                    <option value="banner">Banner</option>
                                    <option value="sponsored">Sponsored Quiz</option>
                                    <option value="announcement">Announcement</option>
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Initial Status</label>
                                <select id="status" name="status" required class="w-full px-2.5 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]">
                                    <option value="active">Active</option>
                                    <option value="paused">Paused</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="badge_text" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Badge Text</label>
                                <input type="text" id="badge_text" name="badge_text" value="SPONSORED"
                                    class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]" />
                            </div>
                            <div>
                                <label for="cta_text" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">CTA Label</label>
                                <input type="text" id="cta_text" name="cta_text" value="Learn More" required
                                    class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]" />
                            </div>
                        </div>

                        <div>
                            <label for="target_url" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Destination URL</label>
                            <input type="url" id="target_url" name="target_url" required
                                class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] font-mono" placeholder="https://..." />
                        </div>

                        <div>
                            <label for="content" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Body Description</label>
                            <textarea id="content" name="content" rows="2"
                                class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB]" placeholder="Copy shown on banner placements..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all">
                            Publish Placement
                        </button>
                    </form>
                </div>
            </div>

            <!-- Active Campaigns Table (2 cols) with Side-Scrolling on Mobile -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Active & Scheduled Campaigns</h2>
                    <span class="text-xs text-slate-500 dark:text-zinc-500 font-mono">{{ $campaigns->total() }} campaigns</span>
                </div>

                <div class="glass-card overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs min-w-[650px]">
                            <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Headline</th>
                                    <th class="py-3 px-4">Type</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Impressions</th>
                                    <th class="py-3 px-4">Clicks (CTR)</th>
                                    <th class="py-3 px-4 text-right">Controls</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                @forelse($campaigns as $camp)
                                @php
                                    $ctr = $camp->impressions > 0 ? round(($camp->clicks / $camp->impressions) * 100, 2) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-[#0F172A] dark:text-zinc-100 max-w-xs truncate">{{ $camp->title }}</div>
                                        <a href="{{ $camp->target_url }}" target="_blank" class="text-[10px] text-[#2563EB] dark:text-[#3B82F6] font-mono hover:underline truncate max-w-xs block">
                                            {{ $camp->target_url }}
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700 uppercase">
                                            {{ $camp->type }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <form action="{{ route('admin.campaigns.toggle', $camp->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2 py-0.5 rounded-lg text-[10px] font-mono font-semibold transition-all {{ $camp->status === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400' }}">
                                                {{ strtoupper($camp->status) }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-[#0F172A] dark:text-zinc-300">
                                        {{ number_format($camp->impressions) }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">
                                        {{ number_format($camp->clicks) }} ({{ $ctr }}%)
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('admin.campaigns.destroy', $camp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-confirm="Remove campaign '{{ $camp->title }}'?" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-slate-600 dark:text-zinc-400 hover:text-rose-600">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-500 dark:text-zinc-500">No campaigns registered.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
