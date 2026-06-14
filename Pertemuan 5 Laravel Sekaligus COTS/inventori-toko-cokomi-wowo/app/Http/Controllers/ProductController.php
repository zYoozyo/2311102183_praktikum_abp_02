<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * ProductController
 *
 * Menangani seluruh operasi CRUD (Create, Read, Update, Delete)
 * untuk manajemen produk pada sistem inventari
 * Toko Cokomi & Wowo.
 */
class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk (Data Table).
     * Mendukung pencarian, filter kategori, dan pengurutan.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        // Filter pencarian berdasarkan nama atau SKU
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filter berdasarkan status aktif
        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        // Pengurutan kolom
        $sortBy  = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $allowedSorts = ['name', 'category', 'price', 'stock', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $products   = $query->paginate(10)->withQueryString();
        $categories = Product::$categories;
        $stats = [
            'total'        => Product::count(),
            'active'       => Product::where('is_active', true)->count(),
            'low_stock'    => Product::where('stock', '<=', 10)->where('is_active', true)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create(): View
    {
        $categories = Product::$categories;
        $units      = Product::$units;

        return view('products.create', compact('categories', 'units'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|in:' . implode(',', Product::$categories),
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|string|in:' . implode(',', Product::$units),
            'sku'         => 'nullable|string|max:50|unique:products,sku',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required'      => 'Nama produk wajib diisi.',
            'category.required'  => 'Kategori wajib dipilih.',
            'category.in'        => 'Kategori tidak valid.',
            'price.required'     => 'Harga jual wajib diisi.',
            'price.numeric'      => 'Harga harus berupa angka.',
            'stock.required'     => 'Stok wajib diisi.',
            'stock.integer'      => 'Stok harus berupa bilangan bulat.',
            'sku.unique'         => 'SKU sudah digunakan produk lain.',
            'image.image'        => 'File harus berupa gambar.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        // Auto-generate SKU jika kosong
        if (empty($validated['sku'])) {
            $validated['sku'] = $this->generateSku($validated['category']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$validated['name']}\" berhasil ditambahkan! 🎉");
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        $categories = Product::$categories;
        $units      = Product::$units;

        return view('products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Memperbarui data produk yang sudah ada.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|in:' . implode(',', Product::$categories),
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|string|in:' . implode(',', Product::$units),
            'sku'         => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required'      => 'Nama produk wajib diisi.',
            'category.required'  => 'Kategori wajib dipilih.',
            'price.required'     => 'Harga jual wajib diisi.',
            'stock.required'     => 'Stok wajib diisi.',
            'sku.unique'         => 'SKU sudah digunakan produk lain.',
            'image.image'        => 'File harus berupa gambar.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload gambar baru dan hapus yang lama
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil diperbarui! ✅");
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        // Hapus gambar produk dari storage
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus! 🗑️");
    }

    // ==========================================
    // Helper Methods (Private)
    // ==========================================

    /**
     * Upload gambar produk ke storage.
     */
    private function uploadImage($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('products', $filename, 'public');
        return $filename;
    }

    /**
     * Generate SKU otomatis berdasarkan kategori.
     */
    private function generateSku(string $category): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category), 0, 3));
        $number = str_pad(Product::count() + 1, 4, '0', STR_PAD_LEFT);
        $suffix = strtoupper(Str::random(2));
        return "{$prefix}-{$number}-{$suffix}";
    }
}
