<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🔍 Detail Produk
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden">
                {{-- Header --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-start justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center text-3xl shrink-0">
                            📦
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $product->category }}</p>
                            <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/60 dark:text-green-300' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('products.edit', $product) }}"
                           class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Harga Jual</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    @if($product->cost_price)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Harga Modal</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">
                            Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                            Margin: Rp {{ number_format($product->price - $product->cost_price, 0, ',', '.') }}
                        </p>
                    </div>
                    @endif

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Stok</p>
                        <p class="text-lg font-bold {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 10 ? 'text-yellow-600' : 'text-gray-900 dark:text-white') }} mt-1">
                            {{ $product->stock }} {{ $product->unit }}
                        </p>
                        @if($product->stock <= 0)
                            <p class="text-xs text-red-500 mt-0.5">⚠ Stok habis!</p>
                        @elseif($product->stock <= 10)
                            <p class="text-xs text-yellow-500 mt-0.5">⚠ Stok menipis!</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">SKU</p>
                        <p class="text-sm font-mono font-medium text-gray-900 dark:text-white mt-1">
                            {{ $product->sku ?? '-' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ditambahkan</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">
                            {{ $product->created_at->locale('id')->isoFormat('D MMM Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Diperbarui</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">
                            {{ $product->updated_at->locale('id')->isoFormat('D MMM Y') }}
                        </p>
                    </div>
                </div>

                @if($product->description)
                <div class="px-6 pb-6">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Deskripsi</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Tombol kembali --}}
            <div class="flex justify-end">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-medium text-sm transition border border-gray-200 dark:border-gray-700">
                    ← Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
