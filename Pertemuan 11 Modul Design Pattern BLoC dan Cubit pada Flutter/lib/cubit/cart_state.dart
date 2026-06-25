import 'package:equatable/equatable.dart';
import '../models/product_model.dart';

// State untuk CartCubit
class CartState extends Equatable {
  final List<Product> cartItems;
  final int totalItems;
  final double totalPrice;

  const CartState({
    this.cartItems = const [],
    this.totalItems = 0,
    this.totalPrice = 0.0,
  });

  // Buat state baru dengan cartItems yang diperbarui
  CartState copyWith({
    List<Product>? cartItems,
  }) {
    final items = cartItems ?? this.cartItems;
    return CartState(
      cartItems: items,
      totalItems: items.length,
      totalPrice: items.fold(0.0, (sum, product) => sum + product.price),
    );
  }

  @override
  List<Object?> get props => [cartItems, totalItems, totalPrice];
}
