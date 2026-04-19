<x-layouts.app>
    <div class="flex flex-col gap-6 w-full p-4 sm:p-6">

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8 shadow-lg">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Sisteme Hoş Geldiniz, Şef! 👨‍🍳</h2>
                    <p class="text-indigo-100 text-sm sm:text-base">Mutfaktaki son gelişmeleri ve tariflerinizin güncel özetini buradan takip edebilirsiniz.</p>
                </div>
                <a href="{{ route('recipes.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl shadow-sm hover:bg-indigo-50 hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Yeni Tarif Ekle
                </a>
            </div>
            <svg class="absolute -bottom-12 -right-12 w-56 h-56 text-white opacity-10 pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 7a1 1 0 10-2 0v2H4a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2H8V7z" clip-rule="evenodd"></path></svg>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm hover:border-indigo-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Toplam Tarif</span>
                    <div class="p-2.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="text-4xl font-black text-zinc-900 dark:text-white">{{ $recipeCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm hover:border-amber-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Koleksiyonlar</span>
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-900/30 rounded-lg text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                </div>
                <div class="text-4xl font-black text-zinc-900 dark:text-white">{{ $collectionCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm hover:border-emerald-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Yorumlar</span>
                    <div class="p-2.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                </div>
                <div class="text-4xl font-black text-zinc-900 dark:text-white">{{ $reviewCount }}</div>
            </div>

            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm hover:border-blue-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Kategoriler</span>
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                    </div>
                </div>
                <div class="text-4xl font-black text-zinc-900 dark:text-white">{{ $categoryCount }}</div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden mt-2">
            <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between bg-zinc-50/50 dark:bg-zinc-800/50">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Son Eklenen Tarifler
                </h3>
                <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition-colors">Tümünü Gör &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/80 text-zinc-500 dark:text-zinc-400 uppercase text-xs font-bold tracking-wider border-b border-zinc-200 dark:border-zinc-700">
                    <tr>
                        <th class="px-6 py-4">Tarif Bilgisi</th>
                        <th class="px-6 py-4 hidden md:table-cell">Kategori</th>
                        <th class="px-6 py-4 hidden sm:table-cell">Süre</th>
                        <th class="px-6 py-4 text-right">İşlem</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700/50">
                    @forelse($latestRecipes as $recipe)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($recipe->image_path)
                                        <img src="{{ asset('storage/' . $recipe->image_path) }}" class="w-12 h-12 rounded-lg object-cover shadow-sm group-hover:scale-105 transition-transform" alt="{{ $recipe->title }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->title) }}&background=random&color=fff&size=48" class="w-12 h-12 rounded-lg shadow-sm group-hover:scale-105 transition-transform" alt="Görsel Yok">
                                    @endif
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-white text-base">
                                            {{ $recipe->title }}
                                        </div>
                                        <div class="text-xs text-zinc-400 mt-0.5">
                                            {{ $recipe->created_at->diffForHumans() }} eklendi
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                                        {{ $recipe->category ? $recipe->category->name : 'Kategorisiz' }}
                                    </span>
                            </td>

                            <td class="px-6 py-4 hidden sm:table-cell text-zinc-500 dark:text-zinc-400 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $recipe->prep_time + $recipe->cook_time }} dk
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-50 hover:text-indigo-600 dark:hover:bg-zinc-700 dark:hover:text-indigo-400 transition-all shadow-sm font-semibold text-xs">
                                    Göz At
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-400 italic">
                                Henüz bir tarif eklenmemiş. Eklemeye ne dersin?
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
