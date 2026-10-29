<x-app-layout title="Quiz Management" :breadcrumbs="['Creator' => route('creator.dashboard'), 'Quizzes' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Quiz Management</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Configure published trials, set time limits, and attach question banks</p>
            </div>
            <a href="{{ route('creator.quizzes.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Create New Quiz</span>
            </a>
        </div>

        @if($quizzes->isEmpty())
            <x-empty-state 
                icon="fa-solid fa-layer-group" 
                iconColor="text-blue-500" 
                title="No quizzes in your library" 
                description="Start authoring your first quiz challenge for the community."
                actionLabel="Create Quiz"
                :actionUrl="route('creator.quizzes.create')"
            />
        @else
            <div class="glass-card overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left text-xs min-w-[650px]">
                        <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                            <tr>
                                <th class="py-3 px-4">Title</th>
                                <th class="py-3 px-4">Category</th>
                                <th class="py-3 px-4">Complexity</th>
                                <th class="py-3 px-4">Items</th>
                                <th class="py-3 px-4">XP</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                            @foreach($quizzes as $q)
                            <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-[#0F172A] dark:text-zinc-100">{{ $q->title }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono">{{ $q->plays_count }} plays • {{ number_format($q->rating, 1) }} ★</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-zinc-300">
                                        <i class="{{ $q->category->icon }} text-[#2563EB] dark:text-[#3B82F6]"></i>
                                        <span>{{ $q->category->name }}</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <x-badge :variant="$q->difficulty === 'easy' ? 'emerald' : ($q->difficulty === 'hard' ? 'rose' : 'amber')" size="sm">
                                        {{ ucfirst($q->difficulty) }}
                                    </x-badge>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[#0F172A] dark:text-zinc-300 font-semibold">
                                    {{ $q->questions_count }}
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">
                                    +{{ $q->xp_reward }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <form action="{{ route('creator.quizzes.toggle-publish', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-semibold transition-all {{ $q->is_published ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30' : 'bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 border border-slate-300 dark:border-zinc-700' }}">
                                            {{ $q->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('play.quiz', $q->slug) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white" title="Preview Play">
                                            <i class="bi bi-play-fill text-xs"></i>
                                        </a>
                                        <a href="{{ route('creator.quizzes.edit', $q->id) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white" title="Edit">
                                            <i class="bi bi-pencil text-xs"></i>
                                        </a>
                                        <form action="{{ route('creator.quizzes.destroy', $q->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-confirm="Remove quiz '{{ $q->title }}' permanently?" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-slate-600 dark:text-zinc-400 hover:text-rose-600" title="Delete">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
