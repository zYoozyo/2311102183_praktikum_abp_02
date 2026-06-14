<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory untuk model Product.
 * 
 * Digunakan untuk mengisi database dengan data produk
 * contoh menggunakan Faker agar tampilan tidak kosong.
 */
class ProductFactory extends Factory
{
    /**
     * Mendefinisikan state default dari model.
     */
    public function definition(): array
    {
        $categories = [
            'Makanan & Minuman',
            'Sembako',
            'Kebersihan & Perawatan',
            'Elektronik',
            'Pakaian',
            'Alat Tulis',
            'Obat & Kesehatan',
            'Lainnya',
        ];

        $units = ['pcs', 'kg', 'gram', 'liter', 'pak', 'botol', 'sachet', 'box'];

        $price = $this->faker->randomFloat(2, 1000, 500000);
        $costPrice = $price * $this->faker->randomFloat(2, 0.5, 0.85);

        return [
            'name'        => $this->faker->words(3, true),
            'category'    => $this->faker->randomElement($categories),
            'description' => $this->faker->optional(0.8)->sentences(2, true),
            'price'       => $price,
            'cost_price'  => round($costPrice, 2),
            'stock'       => $this->faker->numberBetween(0, 500),
            'unit'        => $this->faker->randomElement($units),
            'sku'         => strtoupper($this->faker->bothify('??-####-??')),
            'image'       => null,
            'is_active'   => $this->faker->boolean(90), // 90% produk aktif
        ];
    }

    /**
     * State: produk tidak aktif.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    /**
     * State: stok habis.
     */
    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }
}
