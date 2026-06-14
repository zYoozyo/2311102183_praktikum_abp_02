<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Product
 * 
 * Merepresentasikan produk dalam sistem inventari
 * Toko Cokomi & Wowo.
 * 
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string|null $description
 * @property float $price
 * @property float|null $cost_price
 * @property int $stock
 * @property string $unit
 * @property string|null $sku
 * @property string|null $image
 * @property bool $is_active
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'cost_price',
        'stock',
        'unit',
        'sku',
        'image',
        'is_active',
    ];

    /**
     * Cast kolom ke tipe data yang tepat.
     */
    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock'      => 'integer',
        'is_active'  => 'boolean',
    ];

    /**
     * Daftar kategori yang tersedia di toko.
     */
    public static array $categories = [
        'Makanan & Minuman',
        'Sembako',
        'Kebersihan & Perawatan',
        'Elektronik',
        'Pakaian',
        'Alat Tulis',
        'Obat & Kesehatan',
        'Lainnya',
    ];

    /**
     * Daftar satuan produk yang tersedia.
     */
    public static array $units = [
        'pcs', 'kg', 'gram', 'liter', 'ml', 'lusin', 'pak', 'botol', 'sachet', 'box',
    ];

    /**
     * Accessor: mendapatkan URL gambar produk.
     * Mengembalikan gambar default jika tidak ada gambar.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/products/' . $this->image))) {
            return asset('storage/products/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    /**
     * Scope untuk produk yang aktif saja.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk filter berdasarkan kategori.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
