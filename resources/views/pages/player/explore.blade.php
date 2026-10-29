<x-app-layout title="Explore Quizzes" :breadcrumbs="['Console' => route('dashboard'), 'Explore' => null]">
    <div class="space-y-6 max-w-7xl mx-auto">
        <!-- Header & Search Bento -->
        <div class="glass-card p-6 border-blue-500/20 bg-gradient-to-r from-blue-900/20 via-slate-100 dark:via-zinc-900/60 to-white dark:to-zinc-900/40">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-[#2563EB] dark:text-[#3B82F6] text-[11px] font-mono mb-2">
                    <i class="fa-solid fa-compass text-xs"></i>
                    <span>COGNITIVE ARENAS</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-[#0F172A] dark:text-white">Explore Quizzes</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 leading-relaxed">
                    Filter across cutting-edge technical trials, astrophysics, system engineering, and competitive lore.
                </p>
            </div>

            <!-- Filter Controls -->
            <form method="GET" action="{{ route('explore') }}" class="mt-6 space-y-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 dark:text-zinc-500">
                            <i class="bi bi-search text-xs"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search quizzes by title, topic, or keyword..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900/90 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs placeholder-slate-400 dark:placeholder-zinc-500 focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition-all font-mono" />
                    </div>

                    <!-- Difficulty selector -->
                    <select name="difficulty" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900/90 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] transition-all font-mono">
                        <option value="">All Difficulties</option>
                        <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>

                    <!-- Sorting -->
                    <select name="sort" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-zinc-900/90 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:outline-none focus:border-[#2563EB] transition-all font-mono">
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                        <option value="reward" {{ request('sort') === 'reward' ? 'selected' : '' }}>Highest XP</option>
                    </select>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white text-xs font-semibold shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-1.5">
                        <i class="bi bi-filter"></i>
                        <span>Filter</span>
                    </button>
                </div>

                <!-- Category Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1 no-scrollbar text-xs">
                    <a href="{{ route('explore', array_merge(request()->except(['category', 'page']), [])) }}"
                        class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-all {{ !request('category') ? 'bg-[#2563EB] dark:bg-[#3B82F6] text-white font-bold shadow-sm' : 'bg-slate-100 dark:bg-zinc-900/80 text-slate-600 dark:text-zinc-400 hover:text-[#2563EB] dark:hover:text-white border border-slate-200 dark:border-zinc-800' }}">
                        All Topics
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('explore', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                        class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-all flex items-center gap-1.5 {{ request('category') === $cat->slug ? 'bg-[#2563EB] dark:bg-[#3B82F6] text-white font-bold shadow-sm' : 'bg-slate-100 dark:bg-zinc-900/80 text-slate-600 dark:text-zinc-400 hover:text-[#2563EB] dark:hover:text-white border border-slate-200 dark:border-zinc-800' }}">
                        <i class="{{ $cat->icon }} text-xs"></i>
                        <span>{{ $cat->name }}</span>
                    </a>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        @if($quizzes->isEmpty())
            <x-empty-state 
                icon="bi bi-search" 
                iconColor="text-blue-500" 
                title="No matching quizzes found" 
                description="We couldn't locate any trials with your current filter selections. Try clearing your filters or searching a different topic."
                actionLabel="Clear Filters"
                :actionUrl="route('explore')"
            />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($quizzes as $quiz)
                    <x-quiz-card :quiz="$quiz" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
