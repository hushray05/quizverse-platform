<x-app-layout title="My Profile" :breadcrumbs="['Console' => route('dashboard'), 'Career Profile' => null]">
    <div class="space-y-8 max-w-5xl mx-auto">
        <!-- Profile Hero Bento -->
        <div class="glass-card p-6 lg:p-8 relative overflow-hidden bg-gradient-to-r from-blue-900/20 via-slate-100 dark:via-zinc-900/60 to-white dark:to-zinc-900/40 border-blue-500/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-2xl border-2 border-[#2563EB] dark:border-[#3B82F6] object-cover shadow-lg shadow-blue-500/20" />
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-extrabold text-[#0F172A] dark:text-white tracking-tight">{{ $user->name }}</h1>
                            <x-badge variant="blue" size="sm">{{ ucfirst($user->role) }}</x-badge>
                        </div>
                        <p class="text-xs text-[#2563EB] dark:text-[#3B82F6] font-mono mt-0.5 font-semibold">Level {{ $user->level }} • {{ $user->rank_title }}</p>
                        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-2 max-w-md">{{ $user->bio ?? 'No bio established yet. Update your profile parameters below.' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-center sm:text-right w-full sm:w-auto">
                    <div class="p-3 rounded-xl bg-white dark:bg-zinc-900/80 border border-slate-200 dark:border-zinc-800 shadow-sm">
                        <span class="text-[10px] font-mono text-slate-500 dark:text-zinc-500 uppercase">Mastery XP</span>
                        <p class="text-base font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">{{ number_format($user->xp) }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-white dark:bg-zinc-900/80 border border-slate-200 dark:border-zinc-800 shadow-sm">
                        <span class="text-[10px] font-mono text-slate-500 dark:text-zinc-500 uppercase">Streak</span>
                        <p class="text-base font-mono font-bold text-orange-500">{{ $user->streak }} Days</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Edit Profile Parameters (1 col) -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Profile Configuration</h2>
                <div class="glass-card p-6">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Display Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] transition-all font-mono" />
                            @error('name')
                                <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Upload Avatar (Local Storage)</label>
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ $user->avatar_url }}" alt="Current Avatar" class="w-10 h-10 rounded-full object-cover border border-[#2563EB]/40" />
                                <span class="text-[11px] text-slate-500 dark:text-zinc-400">Current avatar</span>
                            </div>
                            <input type="file" id="image" name="image" accept="image/*"
                                class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2563EB] file:text-white hover:file:bg-blue-600 cursor-pointer focus:outline-none" />
                            @error('image')
                                <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Bio / Status</label>
                            <textarea id="bio" name="bio" rows="3"
                                class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] transition-all">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-- Complete Match Log (2 cols) with Mobile Side-Scrolling -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-[#0F172A] dark:text-white tracking-tight">Historical Trial Record</h2>
                    <span class="text-xs text-slate-500 dark:text-zinc-500 font-mono">{{ $attempts->total() }} matches</span>
                </div>

                @if($attempts->isEmpty())
                    <x-empty-state 
                        icon="bi bi-clock-history" 
                        iconColor="text-blue-500" 
                        title="No trial history logged" 
                        description="You have not participated in any competitive trials yet."
                        actionLabel="Explore Quizzes"
                        :actionUrl="route('explore')"
                    />
                @else
                    <div class="glass-card overflow-hidden">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left text-xs min-w-[550px]">
                                <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                    <tr>
                                        <th class="py-3 px-4">Trial</th>
                                        <th class="py-3 px-4">Score</th>
                                        <th class="py-3 px-4">Accuracy</th>
                                        <th class="py-3 px-4">XP</th>
                                        <th class="py-3 px-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                    @foreach($attempts as $att)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/40 transition-colors">
                                        <td class="py-3 px-4 font-semibold text-[#0F172A] dark:text-zinc-200">
                                            <div class="truncate max-w-[200px]">{{ $att->quiz->title ?? 'Custom Blitz' }}</div>
                                            <div class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $att->completed_at ? $att->completed_at->format('M d, Y H:i') : 'Recent' }}</div>
                                        </td>
                                        <td class="py-3 px-4 font-mono font-bold text-[#0F172A] dark:text-white">{{ number_format($att->score) }}</td>
                                        <td class="py-3 px-4 font-mono font-semibold {{ $att->accuracy_percentage >= 70 ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                                            {{ $att->accuracy_percentage }}%
                                        </td>
                                        <td class="py-3 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">+{{ $att->xp_earned }}</td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="{{ route('play.results', $att->id) }}" class="text-xs text-[#2563EB] dark:text-[#3B82F6] hover:underline font-bold">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $attempts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
