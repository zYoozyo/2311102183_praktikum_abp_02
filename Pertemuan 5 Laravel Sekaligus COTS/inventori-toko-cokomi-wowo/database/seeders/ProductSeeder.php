<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder
 * 
 * Mengisi tabel products dengan data produk nyata
 * yang representatif untuk toko Cokomi & Wowo,
 * ditambah data random menggunakan ProductFactory.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // Data produk manual — produk "sungguhan" toko
        // =============================================
        $products = [
            [
                'name'        => 'Indomie Goreng',
                'category'    => 'Makanan & Minuman',
                'description' => 'Mie instan goreng favorit seluruh Indonesia. Rasa gurih, praktis, dan mengenyangkan.',
                'price'       => 3500,
                'cost_price'  => 2800,
                'stock'       => 200,
                'unit'        => 'pcs',
                'sku'         => 'MKN-0001-IG',
                'is_active'   => true,
            ],
            [
                'name'        => 'Beras Premium 5 Kg',
                'category'    => 'Sembako',
                'description' => 'Beras putih premium kualitas pulen. Cocok untuk kebutuhan sehari-hari keluarga.',
                'price'       => 72000,
                'cost_price'  => 65000,
                'stock'       => 80,
                'unit'        => 'pak',
                'sku'         => 'SMB-0002-BR',
                'is_active'   => true,
            ],
            [
                'name'        => 'Minyak Goreng Bimoli 2L',
                'category'    => 'Sembako',
                'description' => 'Minyak goreng serbaguna dari kelapa sawit pilihan. Jernih dan sehat.',
                'price'       => 35000,
                'cost_price'  => 30000,
                'stock'       => 50,
                'unit'        => 'botol',
                'sku'         => 'SMB-0003-MG',
                'is_active'   => true,
            ],
            [
                'name'        => 'Sabun Lifebuoy 75g',
                'category'    => 'Kebersihan & Perawatan',
                'description' => 'Sabun mandi antibakteri menjaga kulit bersih dan sehat sepanjang hari.',
                'price'       => 4500,
                'cost_price'  => 3500,
                'stock'       => 150,
                'unit'        => 'pcs',
                'sku'         => 'KBR-0004-SB',
                'is_active'   => true,
            ],
            [
                'name'        => 'Shampo Sunsilk 70ml',
                'category'    => 'Kebersihan & Perawatan',
                'description' => 'Sampo untuk rambut berkilau dan lembut. Tersedia berbagai varian.',
                'price'       => 7000,
                'cost_price'  => 5500,
                'stock'       => 100,
                'unit'        => 'botol',
                'sku'         => 'KBR-0005-SP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Gula Pasir 1 Kg',
                'category'    => 'Sembako',
                'description' => 'Gula pasir putih halus untuk berbagai kebutuhan masak dan minuman.',
                'price'       => 17000,
                'cost_price'  => 14500,
                'stock'       => 120,
                'unit'        => 'kg',
                'sku'         => 'SMB-0006-GP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Teh Celup Sosro 25 Kantong',
                'category'    => 'Makanan & Minuman',
                'description' => 'Teh celup premium dengan rasa teh asli yang khas dan harum.',
                'price'       => 11000,
                'cost_price'  => 8500,
                'stock'       => 90,
                'unit'        => 'box',
                'sku'         => 'MKN-0007-TC',
                'is_active'   => true,
            ],
            [
                'name'        => 'Baterai AA Alkaline (2 pcs)',
                'category'    => 'Elektronik',
                'description' => 'Baterai AA alkaline tahan lama untuk berbagai perangkat elektronik.',
                'price'       => 12000,
                'cost_price'  => 9000,
                'stock'       => 60,
                'unit'        => 'pak',
                'sku'         => 'ELK-0008-BA',
                'is_active'   => true,
            ],
            [
                'name'        => 'Paracetamol 500mg Strip',
                'category'    => 'Obat & Kesehatan',
                'description' => 'Obat pereda demam dan nyeri ringan. Aman untuk dewasa dan anak.',
                'price'       => 5000,
                'cost_price'  => 3500,
                'stock'       => 200,
                'unit'        => 'pak',
                'sku'         => 'OBT-0009-PC',
                'is_active'   => true,
            ],
            [
                'name'        => 'Buku Tulis Sidu 58 Lembar',
                'category'    => 'Alat Tulis',
                'description' => 'Buku tulis bergaris standar untuk sekolah dan kantor.',
                'price'       => 4000,
                'cost_price'  => 3000,
                'stock'       => 300,
                'unit'        => 'pcs',
                'sku'         => 'ATK-0010-BT',
                'is_active'   => true,
            ],
            [
                'name'        => 'Pulpen Pilot G2 Hitam',
                'category'    => 'Alat Tulis',
                'description' => 'Pulpen gel berkualitas tinggi dengan tinta hitam pekat dan nyaman digenggam.',
                'price'       => 9000,
                'cost_price'  => 7000,
                'stock'       => 150,
                'unit'        => 'pcs',
                'sku'         => 'ATK-0011-PP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kaos Polos Pria — Putih (M)',
                'category'    => 'Pakaian',
                'description' => 'Kaos polos bahan cotton combed 30s, adem dan nyaman dipakai sehari-hari.',
                'price'       => 45000,
                'cost_price'  => 32000,
                'stock'       => 25,
                'unit'        => 'pcs',
                'sku'         => 'PKN-0012-KP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kopi Kapal Api Special Mix 20 Sachet',
                'category'    => 'Makanan & Minuman',
                'description' => 'Kopi mix 3-in-1 dengan perpaduan kopi, susu, dan gula yang sempurna.',
                'price'       => 22000,
                'cost_price'  => 17000,
                'stock'       => 75,
                'unit'        => 'box',
                'sku'         => 'MKN-0013-KK',
                'is_active'   => true,
            ],
            [
                'name'        => 'Detergen Rinso 800g',
                'category'    => 'Kebersihan & Perawatan',
                'description' => 'Detergen bubuk ampuh mengangkat noda membandel pada pakaian.',
                'price'       => 18000,
                'cost_price'  => 14000,
                'stock'       => 70,
                'unit'        => 'pak',
                'sku'         => 'KBR-0014-DT',
                'is_active'   => true,
            ],
            [
                'name'        => 'Masker Medis 3-Ply (50 pcs)',
                'category'    => 'Obat & Kesehatan',
                'description' => 'Masker medis 3 lapis, nyaman dipakai dan efektif menyaring partikel.',
                'price'       => 35000,
                'cost_price'  => 25000,
                'stock'       => 40,
                'unit'        => 'box',
                'sku'         => 'OBT-0015-MK',
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Tambah 20 produk random menggunakan factory
        Product::factory(20)->create();

        // Tambah 5 produk stok habis
        Product::factory(5)->outOfStock()->create();
    }
}
