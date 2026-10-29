<x-app-layout title="Category Management" :breadcrumbs="['Governance' => route('admin.overview'), 'Categories' => null]">
    <div class="space-y-8" x-data="{ editingCategory: null, isCreating: false }">

        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[#0F172A] dark:text-white">Knowledge Domain Management</h1>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Organize quiz taxonomy, upload custom category icons, and manage domain status.</p>
            </div>

            <button @click="isCreating = !isCreating" type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow transition-all">
                <i class="fa-solid fa-plus text-xs"></i>
                <span x-text="isCreating ? 'Close Form' : 'New Category'">New Category</span>
            </button>
        </div>

        <!-- Create Category Form (Collapsible via Alpine) -->
        <div x-show="isCreating" x-transition class="glass-card p-6 border border-blue-500/30" style="display: none;">
            <h3 class="text-sm font-bold text-[#0F172A] dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-folder-plus text-blue-500"></i>
                <span>Create New Category Domain</span>
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Domain Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Artificial Intelligence"
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Icon Class (FontAwesome / Devicon)</label>
                        <input type="text" name="icon" placeholder="e.g. fa-solid fa-microchip"
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Upload Icon/Image (Local Storage)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-blue-600 file:text-white cursor-pointer" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Brief overview of this knowledge domain..."
                        class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button @click="isCreating = false" type="button" class="px-4 py-2 rounded-xl text-xs text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow">Save Category</button>
                </div>
            </form>
        </div>

        <!-- Categories Responsive Grid (grid-cols-1 md:grid-cols-2 lg:grid-cols-3) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="glass-card p-5 flex flex-col justify-between group relative">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl overflow-hidden">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-auto object-cover" />
                                @else
                                    <i class="{{ $category->icon ?? 'fa-solid fa-folder' }}"></i>
                                @endif
                            </div>

                            <span class="text-[11px] font-mono px-2 py-0.5 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-600 dark:text-zinc-400 border border-slate-200 dark:border-zinc-700">
                                {{ $category->quizzes_count }} Quizzes
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-[#0F172A] dark:text-white group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 line-clamp-2">
                            {{ $category->description ?? 'No description provided for this domain.' }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
                        <span class="text-[10px] font-mono text-slate-400">slug: {{ $category->slug }}</span>

                        <div class="flex items-center gap-1">
                            <!-- Edit Trigger Modal/Form toggle -->
                            <button @click="editingCategory = {{ $category->toJson() }}" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors" title="Edit Category">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>

                            <!-- Delete Form with Data-Confirm SweetAlert2 -->
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-confirm="Are you sure you want to delete category '{{ $category->name }}'? This will affect linked quizzes." class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" title="Delete Category">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Edit Category Modal via Alpine -->
        <div x-show="editingCategory" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
            <div @click.away="editingCategory = null" class="w-full max-w-lg bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-[#0F172A] dark:text-white">Edit Category</h3>
                    <button @click="editingCategory = null" type="button" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="'/admin/categories/' + (editingCategory ? editingCategory.id : '')" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-zinc-300">Category Name</label>
                        <input type="text" name="name" :value="editingCategory ? editingCategory.name : ''" required
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-[#0F172A] dark:text-white text-xs" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-zinc-300">Icon Class</label>
                        <input type="text" name="icon" :value="editingCategory ? editingCategory.icon : ''"
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-[#0F172A] dark:text-white text-xs font-mono" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-zinc-300">Upload New Image (Optional)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-xs text-slate-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-zinc-300">Description</label>
                        <textarea name="description" rows="3" :value="editingCategory ? editingCategory.description : ''"
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-[#0F172A] dark:text-white text-xs"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button @click="editingCategory = null" type="button" class="px-4 py-2 rounded-xl text-xs text-slate-500">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
