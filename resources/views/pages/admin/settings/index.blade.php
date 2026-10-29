<x-app-layout title="Platform Settings" :breadcrumbs="['Governance' => route('admin.overview'), 'Settings' => null]">
    <div class="space-y-6 max-w-4xl mx-auto">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] dark:text-white">Platform Settings & Runtime Configuration</h1>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Configure global engine behavior, gameplay caps, defense shields, and ad toggles</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            @foreach($settingsByGroup as $groupName => $settings)
            <div class="glass-card p-6 space-y-4 border-slate-200 dark:border-zinc-800">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-zinc-800">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2563EB] dark:bg-[#3B82F6]"></span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#0F172A] dark:text-white font-mono">{{ $groupName }} Configuration</h3>
                </div>

                <div class="space-y-4">
                    @foreach($settings as $setting)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-900/60 border border-slate-200 dark:border-zinc-800/80">
                        <div class="max-w-md">
                            <label for="setting-{{ $setting->key }}" class="block text-xs font-semibold text-[#0F172A] dark:text-zinc-200">{{ $setting->label }}</label>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5">{{ $setting->description }}</p>
                        </div>

                        <div class="w-full sm:w-64">
                            @if($setting->type === 'boolean')
                                <select id="setting-{{ $setting->key }}" name="settings[{{ $setting->key }}]" class="w-full px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-950 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]">
                                    <option value="true" {{ $setting->value === 'true' ? 'selected' : '' }}>Enabled / Active</option>
                                    <option value="false" {{ $setting->value === 'false' ? 'selected' : '' }}>Disabled / Inactive</option>
                                </select>
                            @else
                                <input type="{{ $setting->type === 'integer' ? 'number' : 'text' }}" id="setting-{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                    class="w-full px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-950 border border-slate-200 dark:border-zinc-800 text-[#0F172A] dark:text-white text-xs font-mono focus:outline-none focus:border-[#2563EB]" />
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-[#2563EB] hover:bg-blue-600 dark:bg-[#3B82F6] dark:hover:bg-blue-500 text-white shadow-md shadow-blue-500/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Apply Runtime Configurations</span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
