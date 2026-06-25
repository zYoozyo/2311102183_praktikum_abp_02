# Laporan Praktikum Pertemuan 11
## Implementasi State Management dengan BLoC/Cubit pada Flutter

**Nama:** Muhammad Ragiel Prastyo  
**NIM:** 2311102183  
**Mata Kuliah:** Aplikasi Berbasis Platform  

---

## 1. Deskripsi Aplikasi

Aplikasi **TechStore** adalah aplikasi daftar produk sederhana berbasis Flutter yang mengimplementasikan **Cubit** (bagian dari library `flutter_bloc`) sebagai state management. Aplikasi ini menampilkan 7 produk elektronik dan aksesoris dengan fitur menambah/menghapus produk dari keranjang belanja secara real-time.

---

## 2. Struktur Proyek

```
lib/
├── main.dart                        # Entry point + BlocProvider
├── models/
│   └── product_model.dart           # Model data produk + sample data
├── cubit/
│   ├── cart_cubit.dart              # Logika bisnis (addProduct, removeProduct, clearCart)
│   └── cart_state.dart              # State keranjang (cartItems, totalItems, totalPrice)
└── screens/
    └── product_list_screen.dart     # UI: ProductListScreen + _CartBottomSheet
```

---

## 3. Implementasi BLoC/Cubit

### 3.1 CartState (`cart_state.dart`)

`CartState` merupakan kelas immutable yang merepresentasikan kondisi keranjang saat ini. Menggunakan `Equatable` untuk perbandingan state yang efisien agar UI hanya rebuild ketika state benar-benar berubah.

```dart
class CartState extends Equatable {
  final List<Product> cartItems;
  final int totalItems;
  final double totalPrice;

  CartState copyWith({List<Product>? cartItems}) {
    final items = cartItems ?? this.cartItems;
    return CartState(
      cartItems: items,
      totalItems: items.length,
      totalPrice: items.fold(0.0, (sum, p) => sum + p.price),
    );
  }
}
```

### 3.2 CartCubit (`cart_cubit.dart`)

`CartCubit` extends `Cubit<CartState>` dan berisi semua logika bisnis pengelolaan keranjang:

```dart
class CartCubit extends Cubit<CartState> {
  CartCubit() : super(const CartState());

  void addProduct(Product product) {
    final updatedCart = List<Product>.from(state.cartItems)..add(product);
    emit(state.copyWith(cartItems: updatedCart)); // emit state baru
  }

  void removeProduct(Product product) {
    final updatedCart = List<Product>.from(state.cartItems);
    final index = updatedCart.indexWhere((p) => p.id == product.id);
    if (index != -1) {
      updatedCart.removeAt(index);
      emit(state.copyWith(cartItems: updatedCart));
    }
  }

  void clearCart() => emit(const CartState());
}
```

### 3.3 BlocProvider (`main.dart`)

`BlocProvider` digunakan di `main.dart` untuk menyediakan `CartCubit` ke seluruh widget tree:

```dart
BlocProvider(
  create: (context) => CartCubit(),
  child: MaterialApp(home: const ProductListScreen()),
)
```

### 3.4 BlocBuilder (UI)

`BlocBuilder<CartCubit, CartState>` digunakan di berbagai titik UI untuk rebuild otomatis saat state berubah:

- **AppBar badge**: Menampilkan jumlah item keranjang secara real-time
- **Header card**: Menampilkan total item dan total harga
- **ProductCard**: Mengubah tampilan tombol (Add → counter +/-) ketika produk ada di keranjang
- **CartBottomSheet**: Menampilkan daftar item dan total belanja

---

## 4. Fitur Aplikasi

| Fitur | Implementasi |
|-------|-------------|
| Daftar 7 produk dalam grid | `GridView.builder` + `List<Product>` |
| Tambah produk ke keranjang | `CartCubit.addProduct()` → `emit()` |
| Hapus produk dari keranjang | `CartCubit.removeProduct()` → `emit()` |
| Jumlah item real-time di AppBar | `BlocBuilder` + `AnimatedSwitcher` |
| Kartu produk berubah saat di-cart | `BlocBuilder` → conditional widget |
| Bottom sheet keranjang | `showModalBottomSheet` + `BlocProvider.value` |
| Kosongkan keranjang | `CartCubit.clearCart()` → `emit(CartState())` |
| Checkout dengan notifikasi | `SnackBar` + `clearCart()` |

---

## 5. Alur State Management

```
User Tap "Tambah" 
    → CartCubit.addProduct(product)
    → List baru dibuat (immutable)  
    → emit(newState)
    → BlocBuilder rebuild semua widget yang listen
    → UI terupdate secara real-time
```

---

## 6. Dependency yang Digunakan

```yaml
dependencies:
  flutter_bloc: ^9.0.0   # Library BLoC/Cubit
  equatable: ^2.0.7      # Perbandingan state yang efisien
```

---

## 7. Kesimpulan

Cubit merupakan versi yang lebih sederhana dari BLoC yang tidak memerlukan Event class terpisah. State diubah langsung melalui method pada Cubit dengan memanggil `emit()`. Pola ini sangat efektif untuk state management skala menengah seperti shopping cart, karena:

1. **Mudah dipahami**: Tidak perlu mendefinisikan Event, cukup method biasa
2. **Reaktif**: UI otomatis rebuild melalui `BlocBuilder` saat `emit()` dipanggil
3. **Testable**: Logic terpisah dari UI, mudah di-unit test
4. **Efisien**: `Equatable` mencegah rebuild yang tidak perlu
