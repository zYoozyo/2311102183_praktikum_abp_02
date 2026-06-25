import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'cubit/cart_cubit.dart';
import 'screens/product_list_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      // Menyediakan CartCubit ke seluruh widget tree
      create: (context) => CartCubit(),
      child: MaterialApp(
        title: 'TechStore - BLoC & Cubit',
        debugShowCheckedModeBanner: false,
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(
            seedColor: const Color(0xFF6C63FF),
            brightness: Brightness.dark,
          ),
          fontFamily: 'sans-serif',
          useMaterial3: true,
        ),
        home: const ProductListScreen(),
      ),
    );
  }
}
