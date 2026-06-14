<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🏪 Dashboard — Toko Cokomi & Wowo
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Sambutan --}}
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">Selamat datang,</p>
                        <h1 class="text-2xl font-bold mt-1">{{ Auth::user()->name }} 👋</h1>
                        <p class="text-indigo-100 text-sm mt-2">
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                    <div class="text-6xl opacity-80">🛒</div>
                </div>
            </div>

            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center text-2xl">📦</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Produk Aktif</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ number_format($stats['active']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center text-2xl">✅</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok Menipis</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ number_format($stats['low_stock']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center text-2xl">⚠️</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok Habis</p>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ number_format($stats['out_of_stock']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center text-2xl">❌</div>
                    </div>
                </div>
            </div>

            {{-- Produk Terbaru --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-white">📋 Produk Terbaru</h3>
                    <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        Lihat semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Stok</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentProducts as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $product->name }}</td>
                                <td class="px-6 py-3 text-gray-500 dark:text-gray-400">{{ $product->category }}</td>
                                <td class="px-6 py-3 text-right text-gray-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-right">
                                    <span class="{{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 10 ? 'text-yellow-600' : 'text-gray-900 dark:text-white') }} font-medium">
                                        {{ $product->stock }} {{ $product->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada produk</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Produk Baru
                </a>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-medium text-sm transition shadow border border-gray-200 dark:border-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Kelola Inventari
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
