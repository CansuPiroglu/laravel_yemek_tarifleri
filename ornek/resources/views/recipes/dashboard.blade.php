<x-layouts.app>
    <div class="flex flex-col gap-6 w-full p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Sisteme Hoş Geldiniz, Şef! 👨‍🍳</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mt-1">Tariflerinizin ve etkileşimlerinizin güncel özeti.</p>
            </div>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Yeni Tarif Ekle
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase">Toplam Tarif</span>
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $recipeCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase">Koleksiyonlar</span>
                    <div class="p-2 bg-amber-50 dark:bg-amber-900/30 rounded-lg text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $collectionCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase">Yorumlar</span>
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $reviewCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase">Kategoriler</span>
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $categoryCount }}</div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden mt-4">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Son Eklenen Tarifler</h3>
                <a href="{{ route('recipes.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Tümünü Gör</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4 text-left">Tarif Adı</th>
                        <th class="px-6 py-4 text-left">Eklenme Tarihi</th>
                        <th class="px-6 py-4 text-right">İşlem</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse($latestRecipes as $recipe)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                {{ $recipe->title }}
                            </td>
                            <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">
                                {{ $recipe->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="inline-flex items-center px-3 py-1 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
                                    İncele
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-zinc-400 italic">
                                Henüz bir tarif eklenmemiş.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
