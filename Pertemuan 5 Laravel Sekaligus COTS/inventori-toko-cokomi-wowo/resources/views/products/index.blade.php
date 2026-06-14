<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📦 Manajemen Produk
            </h2>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div id="flash-success" class="flex items-center gap-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl text-sm shadow">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistik Mini --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 shadow border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                    <span class="text-2xl">📦</span>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 shadow border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Aktif</p>
                        <p class="font-bold text-green-600 dark:text-green-400">{{ $stats['active'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 shadow border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Stok Menipis</p>
                        <p class="font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['low_stock'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 shadow border border-gray-100 dark:border-gray-700 flex items-center gap-3">
                    <span class="text-2xl">❌</span>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Habis</p>
                        <p class="font-bold text-red-600 dark:text-red-400">{{ $stats['out_of_stock'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Filter & Search --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-4">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="flex-1 min-w-48">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama produk atau SKU..."
                                   class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <select name="category" class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    {{-- Status --}}
                    <select name="status" class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search','category','status']))
                    <a href="{{ route('products.index') }}" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            {{-- Data Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_dir' => request('sort_dir') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                        Produk
                                        @if(request('sort_by') === 'name') <span>{{ request('sort_dir') === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Kategori</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price', 'sort_dir' => request('sort_dir') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center justify-end gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                        Harga
                                        @if(request('sort_by') === 'price') <span>{{ request('sort_dir') === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'stock', 'sort_dir' => request('sort_dir') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center justify-end gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                        Stok
                                        @if(request('sort_by') === 'stock') <span>{{ request('sort_dir') === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">SKU</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition group">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                    @if($product->description)
                                    <div class="text-xs text-gray-400 truncate max-w-xs">{{ $product->description }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($product->stock <= 0)
                                        <span class="text-red-600 dark:text-red-400 font-semibold">0 {{ $product->unit }}</span>
                                    @elseif($product->stock <= 10)
                                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ $product->stock }} {{ $product->unit }}</span>
                                    @else
                                        <span class="text-gray-900 dark:text-white">{{ $product->stock }} {{ $product->unit }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 font-mono text-xs">
                                    {{ $product->sku ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/60 dark:text-green-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Lihat --}}
                                        <a href="{{ route('products.show', $product) }}"
                                           class="p-1.5 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition"
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition"
                                           title="Edit Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        {{-- Hapus --}}
                                        <button type="button"
                                                onclick="openDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                class="p-1.5 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition"
                                                title="Hapus Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="text-5xl mb-3">📭</div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada produk ditemukan.</p>
                                    @if(request()->hasAny(['search','category','status']))
                                        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline text-sm mt-1 block">Hapus filter</a>
                                    @else
                                        <a href="{{ route('products.create') }}" class="text-indigo-600 hover:underline text-sm mt-1 block">Tambah produk pertama</a>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                    {{ $products->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-modal="true">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        {{-- Modal Box --}}
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 border border-gray-100 dark:border-gray-700 animate-modal">
                {{-- Icon --}}
                <div class="mx-auto w-16 h-16 bg-red-100 dark:bg-red-900/40 rounded-full flex items-center justify-center text-3xl mb-4">
                    🗑️
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white text-center">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">
                    Apakah kamu yakin ingin menghapus produk
                    <br><strong id="deleteProductName" class="text-gray-900 dark:text-white"></strong>?
                    <br><span class="text-red-500 text-xs mt-1 block">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
                <form id="deleteForm" method="POST" class="mt-6 flex gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-2.5 rounded-xl font-medium text-sm transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl font-medium text-sm transition shadow">
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal { animation: modalIn 0.2s ease-out; }
    </style>

    <script>
        function openDeleteModal(id, name) {
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteForm').action = `/products/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });

        // Auto-hide flash message
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) flash.style.opacity = '0', flash.style.transition = 'opacity 0.5s', setTimeout(() => flash.remove(), 500);
        }, 4000);
    </script>
</x-app-layout>
