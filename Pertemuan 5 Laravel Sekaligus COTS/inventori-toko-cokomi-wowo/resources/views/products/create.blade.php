<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ➕ Tambah Produk Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden">
                {{-- Header Form --}}
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Informasi Produk</h3>
                    <p class="text-indigo-100 text-sm mt-0.5">Isi data produk yang ingin ditambahkan ke inventari toko.</p>
                </div>

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf

                    {{-- Validasi Error Global --}}
                    @if($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl p-4">
                        <div class="flex items-center gap-2 text-red-700 dark:text-red-300 font-medium text-sm mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Terdapat {{ $errors->count() }} kesalahan:
                        </div>
                        <ul class="list-disc list-inside text-red-600 dark:text-red-400 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Nama & Kategori --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   placeholder="Contoh: Indomie Goreng"
                                   class="w-full px-4 py-2.5 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category"
                                    class="w-full px-4 py-2.5 border {{ $errors->has('category') ? 'border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Deskripsi <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Deskripsi singkat tentang produk ini..."
                                  class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Harga Jual & Modal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Harga Jual (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                <input type="number" id="price" name="price" value="{{ old('price') }}"
                                       min="0" step="100" placeholder="0"
                                       class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('price') ? 'border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            </div>
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="cost_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Harga Modal (Rp) <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                <input type="number" id="cost_price" name="cost_price" value="{{ old('cost_price') }}"
                                       min="0" step="100" placeholder="0"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            </div>
                            @error('cost_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Stok & Satuan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Jumlah Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
                                   min="0" placeholder="0"
                                   class="w-full px-4 py-2.5 border {{ $errors->has('stock') ? 'border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select id="unit" name="unit"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @foreach($units as $u)
                                    <option value="{{ $u }}" {{ old('unit', 'pcs') === $u ? 'selected' : '' }}>{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Kode SKU <span class="text-gray-400 font-normal text-xs">(dikosongkan = otomatis)</span>
                        </label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                               placeholder="Contoh: MKN-0001-IG"
                               class="w-full px-4 py-2.5 border {{ $errors->has('sku') ? 'border-red-400' : 'border-gray-300 dark:border-gray-600' }} rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Foto Produk <span class="text-gray-400 font-normal text-xs">(opsional, maks. 2MB)</span>
                        </label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/40 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                Produk Aktif
                            </label>
                            <p class="text-xs text-gray-400">Produk aktif akan ditampilkan di sistem inventari.</p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('products.index') }}"
                           class="flex-1 text-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-3 rounded-xl font-medium text-sm transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-medium text-sm transition shadow">
                            💾 Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
