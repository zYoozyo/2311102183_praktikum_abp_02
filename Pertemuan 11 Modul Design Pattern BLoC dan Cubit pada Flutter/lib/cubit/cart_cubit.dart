import 'package:flutter_bloc/flutter_bloc.dart';
import '../models/product_model.dart';
import 'cart_state.dart';

// CartCubit mengelola state keranjang belanja
class CartCubit extends Cubit<CartState> {
  // Inisialisasi dengan CartState kosong
  CartCubit() : super(const CartState());

  // Tambah produk ke keranjang
  void addProduct(Product product) {
    final updatedCart = List<Product>.from(state.cartItems)..add(product);
    emit(state.copyWith(cartItems: updatedCart));
  }

  // Hapus produk dari keranjang (hapus satu instance)
  void removeProduct(Product product) {
    final updatedCart = List<Product>.from(state.cartItems);
    final index = updatedCart.indexWhere((p) => p.id == product.id);
    if (index != -1) {
      updatedCart.removeAt(index);
      emit(state.copyWith(cartItems: updatedCart));
    }
  }

  // Cek apakah produk ada di keranjang
  bool isInCart(String productId) {
    return state.cartItems.any((p) => p.id == productId);
  }

  // Hitung jumlah produk tertentu di keranjang
  int getProductCount(String productId) {
    return state.cartItems.where((p) => p.id == productId).length;
  }

  // Kosongkan keranjang
  void clearCart() {
    emit(const CartState());
  }
}
