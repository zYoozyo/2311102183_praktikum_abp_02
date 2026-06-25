import 'package:equatable/equatable.dart';

class Product extends Equatable {
  final String id;
  final String name;
  final String description;
  final double price;
  final String emoji;
  final String category;

  const Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    required this.emoji,
    required this.category,
  });

  @override
  List<Object?> get props => [id, name, description, price, emoji, category];
}

// Daftar produk sample
final List<Product> sampleProducts = [
  const Product(
    id: '1',
    name: 'Laptop Gaming Pro',
    description: 'Laptop gaming performa tinggi dengan GPU terbaru',
    price: 15000000,
    emoji: '💻',
    category: 'Elektronik',
  ),
  const Product(
    id: '2',
    name: 'Smartphone Ultra',
    description: 'Smartphone flagship dengan kamera 200MP',
    price: 8500000,
    emoji: '📱',
    category: 'Elektronik',
  ),
  const Product(
    id: '3',
    name: 'Headphone Wireless',
    description: 'Headphone noise-cancelling premium',
    price: 1200000,
    emoji: '🎧',
    category: 'Aksesoris',
  ),
  const Product(
    id: '4',
    name: 'Mechanical Keyboard',
    description: 'Keyboard mekanikal RGB dengan switch Cherry MX',
    price: 950000,
    emoji: '⌨️',
    category: 'Aksesoris',
  ),
  const Product(
    id: '5',
    name: 'Monitor 4K UHD',
    description: 'Monitor 27 inci 4K dengan refresh rate 144Hz',
    price: 4500000,
    emoji: '🖥️',
    category: 'Elektronik',
  ),
  const Product(
    id: '6',
    name: 'Mouse Gaming',
    description: 'Mouse gaming dengan DPI tinggi dan desain ergonomis',
    price: 450000,
    emoji: '🖱️',
    category: 'Aksesoris',
  ),
  const Product(
    id: '7',
    name: 'Webcam HD',
    description: 'Webcam 1080p untuk video call dan streaming',
    price: 350000,
    emoji: '📷',
    category: 'Aksesoris',
  ),
];
