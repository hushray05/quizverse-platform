<x-app-layout title="Staff Roles & RBAC" :breadcrumbs="['Governance' => route('admin.overview'), 'Staff & RBAC' => null]">
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Staff Roles & Role-Based Access Control</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Granular privilege delegation and operator authority matrix</p>
            </div>
        </div>

        <!-- Role Definition Bento Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($roles as $role)
            <div class="glass-card p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-[#2563EB] dark:text-[#3B82F6]">
                        <i class="fa-solid fa-shield-halved text-xs"></i>
                    </span>
                    <span class="text-[10px] font-mono text-slate-500 dark:text-zinc-400 bg-slate-100 dark:bg-zinc-800 px-2 py-0.5 rounded">{{ $role->staff_members_count }} assigned</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#0F172A] dark:text-white">{{ $role->name }}</h3>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 line-clamp-2 leading-relaxed">{{ $role->description }}</p>
                </div>
                <!-- Permissions badges -->
                <div class="flex flex-wrap gap-1.5 pt-2 border-t border-slate-200 dark:border-zinc-800/80">
                    @foreach($role->permissions ?? [] as $perm)
                    <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-slate-100 dark:bg-zinc-800/80 text-slate-700 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700/50">
                        {{ $perm }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Staff Assignment Form & Table with Side-Scrolling on Mobile -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Assignment Form (1 col) -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Assign Staff Authority</h2>
                <div class="glass-card p-6">
                    <form action="{{ route('admin.rbac.assign') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="user_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Select User Identity</label>
                            <select id="user_id" name="user_id" required class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                                <option value="">Select Candidate...</option>
                                @foreach($availableUsers as $cand)
                                    <option value="{{ $cand->id }}">{{ $cand->name }} ({{ $cand->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="role_id" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Authority Role</label>
                            <select id="role_id" name="role_id" required class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                                @foreach($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Department Unit</label>
                            <input type="text" id="department" name="department" value="Security & Compliance" required
                                class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono" />
                            @error('department')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-user-shield text-xs"></i>
                            <span>Delegate Privileges</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Active Staff Directory (2 cols) with Side-Scrolling on Mobile -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Active Staff Operators</h2>
                    <span class="text-xs text-slate-500 dark:text-zinc-500 font-mono">{{ $staffMembers->count() }} operators</span>
                </div>

                <div class="glass-card overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs min-w-[650px]">
                            <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Operator</th>
                                    <th class="py-3 px-4">Assigned Role</th>
                                    <th class="py-3 px-4">Department</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                @forelse($staffMembers as $staff)
                                <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $staff->user->avatar_url }}" alt="{{ $staff->user->name }}" class="w-8 h-8 rounded-full border border-blue-500/30 object-cover flex-shrink-0" />
                                            <div>
                                                <p class="font-semibold text-[#0F172A] dark:text-zinc-100">{{ $staff->user->name }}</p>
                                                <p class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $staff->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="text-xs font-bold text-[#2563EB] dark:text-[#3B82F6] font-mono">{{ $staff->role->name }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 dark:text-zinc-400 font-mono text-[11px]">
                                        {{ $staff->department }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-mono px-2 py-0.5 rounded {{ $staff->is_active ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400' }}">
                                            {{ $staff->is_active ? 'AUTHORIZED' : 'SUSPENDED' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('admin.rbac.toggle', $staff->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $staff->is_active ? 'bg-slate-100 dark:bg-zinc-800 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-slate-700 dark:text-zinc-400 hover:text-rose-600' : 'bg-emerald-50 dark:bg-emerald-600/20 text-emerald-600 dark:text-emerald-300 hover:bg-emerald-600 hover:text-white' }}">
                                                {{ $staff->is_active ? 'Suspend' : 'Reactivate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-500 dark:text-zinc-500">No staff members enrolled.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
