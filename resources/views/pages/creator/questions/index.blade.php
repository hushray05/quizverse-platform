<x-app-layout title="Question Bank" :breadcrumbs="['Creator' => route('creator.dashboard'), 'Question Bank' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Question Bank</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Search, organize, filter, and bulk-manage your engineered questions</p>
            </div>
            <a href="{{ route('creator.questions.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Engineer New Question</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="glass-card p-4">
            <form method="GET" action="{{ route('creator.questions.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="relative sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-zinc-500">
                        <i class="bi bi-search text-xs"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search questions..."
                        class="w-full pl-8 pr-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] font-mono" />
                </div>

                <select name="category" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="difficulty" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] font-mono">
                    <option value="">All Difficulties</option>
                    <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
            </form>
        </div>

        @if($questions->isEmpty())
            <x-empty-state 
                icon="fa-solid fa-database" 
                iconColor="text-blue-500" 
                title="No questions located" 
                description="Your bank is currently empty or no items match your search filter."
                actionLabel="Create Question"
                :actionUrl="route('creator.questions.create')"
            />
        @else
            <!-- Bulk Action Form & Table with Side-Scrolling on Mobile -->
            <form id="bulk-form" action="{{ route('creator.questions.bulk-delete') }}" method="POST">
                @csrf
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" class="w-4 h-4 rounded bg-slate-50 dark:bg-zinc-900 border-slate-300 dark:border-zinc-700 text-[#2563EB] focus:ring-0" />
                        <label for="select-all" class="text-xs text-slate-600 dark:text-zinc-400 font-mono cursor-pointer select-none">Select All On Page</label>
                    </div>
                    <button type="submit" data-confirm="Purge all selected questions from your question bank?" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20 hover:bg-rose-600 hover:text-white transition-all flex items-center gap-1.5">
                        <i class="bi bi-trash text-xs"></i>
                        <span>Delete Selected</span>
                    </button>
                </div>

                <div class="glass-card overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs min-w-[700px]">
                            <thead class="bg-slate-100 dark:bg-zinc-900/80 border-b border-slate-200 dark:border-zinc-800 text-slate-500 dark:text-zinc-400 uppercase font-mono text-[10px]">
                                <tr>
                                    <th class="py-3 px-4 w-10"></th>
                                    <th class="py-3 px-4">Question Text</th>
                                    <th class="py-3 px-4">Domain</th>
                                    <th class="py-3 px-4">Assigned Quiz</th>
                                    <th class="py-3 px-4">Points</th>
                                    <th class="py-3 px-4">Complexity</th>
                                    <th class="py-3 px-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-zinc-800/60 font-sans">
                                @foreach($questions as $quest)
                                <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $quest->id }}" class="item-checkbox w-4 h-4 rounded bg-slate-50 dark:bg-zinc-900 border-slate-300 dark:border-zinc-700 text-[#2563EB] focus:ring-0" />
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-[#0F172A] dark:text-zinc-100 line-clamp-1 max-w-md">{{ $quest->question_text }}</div>
                                        <div class="text-[10px] text-slate-500 dark:text-zinc-500 font-mono mt-0.5">
                                            Correct: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $quest->correctOption->option_text ?? 'None set' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-zinc-300">
                                            <i class="{{ $quest->category->icon }} text-[#2563EB] dark:text-[#3B82F6]"></i>
                                            <span>{{ $quest->category->name }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-zinc-400 text-[11px]">
                                        {{ $quest->quiz->title ?? '— Unassigned —' }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#2563EB] dark:text-[#3B82F6]">
                                        {{ $quest->points }} pts
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <x-badge :variant="$quest->difficulty === 'easy' ? 'emerald' : ($quest->difficulty === 'hard' ? 'rose' : 'amber')" size="sm">
                                            {{ ucfirst($quest->difficulty) }}
                                        </x-badge>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('creator.questions.edit', $quest->id) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 hover:text-[#2563EB] dark:hover:text-white" title="Edit">
                                                <i class="bi bi-pencil text-xs"></i>
                                            </a>
                                            <button type="button" onclick="document.getElementById('delete-q-{{ $quest->id }}').submit()" data-confirm="Permanently purge this question?" class="p-1.5 rounded-lg bg-slate-100 dark:bg-zinc-800 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-slate-600 dark:text-zinc-400 hover:text-rose-600" title="Delete">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            @foreach($questions as $quest)
            <form id="delete-q-{{ $quest->id }}" action="{{ route('creator.questions.destroy', $quest->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            @endforeach

            <div class="mt-4">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function toggleSelectAll(master) {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = master.checked);
        }
    </script>
    @endpush
</x-app-layout>
