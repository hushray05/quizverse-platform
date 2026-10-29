<x-app-layout title="User Directory & Moderation" :breadcrumbs="['Governance' => route('admin.overview'), 'User Moderation' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">User Directory & Moderation</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Audit user accounts, enforce platform sanctions, and reassign roles</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-zinc-400">
                <span class="w-2 h-2 rounded-full bg-[#2563EB] dark:bg-[#3B82F6]"></span>
                <span>{{ $users->total() }} Total Identities</span>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="glass-card p-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                        <i class="bi bi-search text-xs"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or email identity..."
                        class="w-full pl-8 pr-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] font-mono" />
                </div>

                <select name="role" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                    <option value="">All Roles</option>
                    <option value="player" {{ request('role') === 'player' ? 'selected' : '' }}>Players</option>
                    <option value="creator" {{ request('role') === 'creator' ? 'selected' : '' }}>Creators</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admins</option>
                </select>

                <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Accounts</option>
                    <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Sanctioned (Banned)</option>
                </select>
            </form>
        </div>

        <!-- Users Table with Side-Scrolling on Mobile -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-xs min-w-[700px]">
                    <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                        <tr>
                            <th class="py-3 px-4">User</th>
                            <th class="py-3 px-4">Role Delegation</th>
                            <th class="py-3 px-4">Level & Rank</th>
                            <th class="py-3 px-4">XP & Streak</th>
                            <th class="py-3 px-4">Sanction State</th>
                            <th class="py-3 px-4 text-right">Moderation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                        @foreach($users as $u)
                        <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors {{ $u->is_banned ? 'bg-rose-50 dark:bg-rose-950/10' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-8 h-8 rounded-full border border-blue-500/30 object-cover flex-shrink-0" />
                                    <div>
                                        <p class="font-semibold text-[#0F172A] dark:text-zinc-100">{{ $u->name }}</p>
                                        <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('admin.users.change-role', $u->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="px-2 py-1 rounded-lg text-xs font-mono bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 focus:outline-none focus:border-[#2563EB]">
                                        <option value="player" {{ $u->role === 'player' ? 'selected' : '' }}>Player</option>
                                        <option value="creator" {{ $u->role === 'creator' ? 'selected' : '' }}>Creator</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-[#0F172A] dark:text-zinc-200">Lv.{{ $u->level }}</span>
                                <div class="text-[10px] text-slate-500 dark:text-zinc-400">{{ $u->rank_title }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                <span class="text-[#2563EB] dark:text-[#3B82F6] font-bold">{{ number_format($u->xp) }} XP</span>
                                <div class="text-[10px] text-orange-500 flex items-center gap-0.5">
                                    <i class="fa-solid fa-fire text-[9px]"></i>
                                    <span>{{ $u->streak }}d streak</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->is_banned)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-mono px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/30 font-semibold">
                                        <i class="bi bi-slash-circle text-xs"></i>
                                        BANNED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30 font-semibold">
                                        <i class="bi bi-check-circle text-xs"></i>
                                        ACTIVE
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-ban', $u->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" data-confirm="{{ $u->is_banned ? 'Restore account access for ' . $u->name . '?' : 'Sanction and suspend ' . $u->name . ' from platform access?' }}"
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold transition-all {{ $u->is_banned ? 'bg-emerald-50 dark:bg-emerald-600/20 text-emerald-600 dark:text-emerald-300 hover:bg-emerald-600 hover:text-white border border-emerald-200 dark:border-emerald-500/30' : 'bg-rose-50 dark:bg-rose-600/20 text-rose-600 dark:text-rose-300 hover:bg-rose-600 hover:text-white border border-rose-200 dark:border-rose-500/30' }}">
                                        {{ $u->is_banned ? 'Lift Ban' : 'Ban User' }}
                                    </button>
                                </form>
                                @else
                                <span class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">Active Operator</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
