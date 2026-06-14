import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Widget Showcase',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF6C63FF),
          brightness: Brightness.light,
        ),
        useMaterial3: true,
      ),
      home: const HomePage(),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// HOME PAGE – bottom nav to switch between demo pages
// ─────────────────────────────────────────────────────────────
class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0;

  final List<Widget> _pages = const [
    ContainerPage(),
    GridViewPage(),
    ListViewPage(),
    ListViewBuilderPage(),
    ListViewSeparatedPage(),
    StackPage(),
  ];

  final List<String> _titles = [
    'Container',
    'GridView',
    'ListView',
    'ListView.builder',
    'ListView.separated',
    'Stack',
  ];

  final List<IconData> _icons = [
    Icons.square_rounded,
    Icons.grid_view_rounded,
    Icons.list_rounded,
    Icons.view_list_rounded,
    Icons.format_list_bulleted_rounded,
    Icons.layers_rounded,
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F5FF),
      appBar: AppBar(
        backgroundColor: const Color(0xFF6C63FF),
        foregroundColor: Colors.white,
        title: Text(
          _titles[_selectedIndex],
          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 20),
        ),
        centerTitle: true,
        elevation: 0,
        shape: const RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(bottom: Radius.circular(20)),
        ),
      ),
      body: _pages[_selectedIndex],
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          boxShadow: [
            BoxShadow(
              color: Colors.black.withValues(alpha: 0.08),
              blurRadius: 20,
              offset: const Offset(0, -4),
            ),
          ],
        ),
        child: SafeArea(
          child: SizedBox(
            height: 70,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 8),
              itemCount: _titles.length,
              itemBuilder: (context, index) {
                final isSelected = _selectedIndex == index;
                return GestureDetector(
                  onTap: () => setState(() => _selectedIndex = index),
                  child: AnimatedContainer(
                    duration: const Duration(milliseconds: 250),
                    margin: const EdgeInsets.symmetric(horizontal: 4),
                    padding:
                        const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: isSelected
                          ? const Color(0xFF6C63FF)
                          : Colors.transparent,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      children: [
                        Icon(
                          _icons[index],
                          size: 18,
                          color: isSelected ? Colors.white : Colors.grey,
                        ),
                        if (isSelected) ...[
                          const SizedBox(width: 6),
                          Text(
                            _titles[index],
                            style: const TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ],
                    ),
                  ),
                );
              },
            ),
          ),
        ),
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 1. CONTAINER PAGE
// ─────────────────────────────────────────────────────────────
class ContainerPage extends StatelessWidget {
  const ContainerPage({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('Container Widget'),
          const SizedBox(height: 16),
          // 1a – solid color
          Container(
            width: double.infinity,
            height: 100,
            decoration: BoxDecoration(
              color: const Color(0xFF6C63FF),
              borderRadius: BorderRadius.circular(16),
            ),
            alignment: Alignment.center,
            child: const Text(
              'Container Berwarna',
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 18,
                  fontWeight: FontWeight.bold),
            ),
          ),
          const SizedBox(height: 16),
          // 1b – gradient
          Container(
            width: double.infinity,
            height: 100,
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [Color(0xFFFF6B6B), Color(0xFFFFE66D)],
                begin: Alignment.centerLeft,
                end: Alignment.centerRight,
              ),
              borderRadius: BorderRadius.circular(16),
            ),
            alignment: Alignment.center,
            child: const Text(
              'Container Gradient',
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 18,
                  fontWeight: FontWeight.bold),
            ),
          ),
          const SizedBox(height: 16),
          // 1c – border + shadow
          Container(
            width: double.infinity,
            height: 100,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(16),
              border: Border.all(color: const Color(0xFF6C63FF), width: 2),
              boxShadow: [
                BoxShadow(
                  color: const Color(0xFF6C63FF).withValues(alpha: 0.2),
                  blurRadius: 12,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            alignment: Alignment.center,
            child: const Text(
              'Container Border & Shadow',
              style: TextStyle(
                  color: Color(0xFF6C63FF),
                  fontSize: 16,
                  fontWeight: FontWeight.bold),
            ),
          ),
          const SizedBox(height: 16),
          // 1d – small colored boxes row
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              _smallBox(const Color(0xFF6C63FF), 'Ungu'),
              _smallBox(const Color(0xFFFF6B6B), 'Merah'),
              _smallBox(const Color(0xFF4ECDC4), 'Tosca'),
              _smallBox(const Color(0xFFFFE66D), 'Kuning'),
            ],
          ),
        ],
      ),
    );
  }

  Widget _smallBox(Color color, String label) {
    return Column(
      children: [
        Container(
          width: 60,
          height: 60,
          decoration: BoxDecoration(
            color: color,
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        const SizedBox(height: 6),
        Text(label,
            style:
                const TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
      ],
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 2. GRIDVIEW PAGE – 8 items
// ─────────────────────────────────────────────────────────────
class GridViewPage extends StatelessWidget {
  const GridViewPage({super.key});

  static const List<Map<String, dynamic>> _items = [
    {'icon': Icons.star_rounded, 'label': 'Favorit', 'color': Color(0xFFFFE66D)},
    {'icon': Icons.favorite_rounded, 'label': 'Suka', 'color': Color(0xFFFF6B6B)},
    {'icon': Icons.music_note_rounded, 'label': 'Musik', 'color': Color(0xFF6C63FF)},
    {'icon': Icons.camera_alt_rounded, 'label': 'Kamera', 'color': Color(0xFF4ECDC4)},
    {'icon': Icons.games_rounded, 'label': 'Game', 'color': Color(0xFFFF8C42)},
    {'icon': Icons.book_rounded, 'label': 'Buku', 'color': Color(0xFF95E1D3)},
    {'icon': Icons.map_rounded, 'label': 'Peta', 'color': Color(0xFFF38181)},
    {'icon': Icons.cloud_rounded, 'label': 'Cloud', 'color': Color(0xFF3FC1C9)},
  ];

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('GridView (${_items.length} item)'),
          const SizedBox(height: 12),
          Expanded(
            child: GridView.count(
              crossAxisCount: 2,
              crossAxisSpacing: 12,
              mainAxisSpacing: 12,
              children: _items
                  .map(
                    (item) => _GridCard(
                      icon: item['icon'] as IconData,
                      label: item['label'] as String,
                      color: item['color'] as Color,
                    ),
                  )
                  .toList(),
            ),
          ),
        ],
      ),
    );
  }
}

class _GridCard extends StatelessWidget {
  final IconData icon;
  final String label;
  final Color color;

  const _GridCard(
      {required this.icon, required this.label, required this.color});

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: color.withValues(alpha: 0.25),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 64,
            height: 64,
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.15),
              shape: BoxShape.circle,
            ),
            child: Icon(icon, color: color, size: 32),
          ),
          const SizedBox(height: 12),
          Text(label,
              style: const TextStyle(
                  fontWeight: FontWeight.bold, fontSize: 16)),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 3. LISTVIEW PAGE – 3 item (A, B, C)
// ─────────────────────────────────────────────────────────────
class ListViewPage extends StatelessWidget {
  const ListViewPage({super.key});

  @override
  Widget build(BuildContext context) {
    final items = [
      {
        'title': 'Item A',
        'subtitle': 'Deskripsi untuk Item A',
        'color': const Color(0xFF6C63FF)
      },
      {
        'title': 'Item B',
        'subtitle': 'Deskripsi untuk Item B',
        'color': const Color(0xFFFF6B6B)
      },
      {
        'title': 'Item C',
        'subtitle': 'Deskripsi untuk Item C',
        'color': const Color(0xFF4ECDC4)
      },
    ];

    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('ListView (3 Item: A, B, C)'),
          const SizedBox(height: 12),
          Expanded(
            child: ListView(
              children: items
                  .map(
                    (item) => _ListCard(
                      title: item['title'] as String,
                      subtitle: item['subtitle'] as String,
                      color: item['color'] as Color,
                    ),
                  )
                  .toList(),
            ),
          ),
        ],
      ),
    );
  }
}

class _ListCard extends StatelessWidget {
  final String title;
  final String subtitle;
  final Color color;

  const _ListCard(
      {required this.title, required this.subtitle, required this.color});

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: color.withValues(alpha: 0.2),
            blurRadius: 10,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: ListTile(
        contentPadding:
            const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
        leading: CircleAvatar(
          backgroundColor: color,
          child: Text(
            title.split(' ').last,
            style: const TextStyle(
                color: Colors.white, fontWeight: FontWeight.bold),
          ),
        ),
        title: Text(title,
            style: const TextStyle(
                fontWeight: FontWeight.bold, fontSize: 16)),
        subtitle:
            Text(subtitle, style: TextStyle(color: Colors.grey[600])),
        trailing: Icon(Icons.arrow_forward_ios_rounded, size: 16, color: color),
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 4. LISTVIEW.BUILDER PAGE – dari data array
// ─────────────────────────────────────────────────────────────
class ListViewBuilderPage extends StatelessWidget {
  const ListViewBuilderPage({super.key});

  static const List<Map<String, String>> _data = [
    {'name': 'Budi Santoso', 'role': 'Flutter Developer', 'avatar': 'BS'},
    {'name': 'Siti Rahayu', 'role': 'UI/UX Designer', 'avatar': 'SR'},
    {'name': 'Ahmad Fauzi', 'role': 'Backend Engineer', 'avatar': 'AF'},
    {'name': 'Dewi Lestari', 'role': 'Project Manager', 'avatar': 'DL'},
    {'name': 'Reza Pratama', 'role': 'DevOps Engineer', 'avatar': 'RP'},
    {'name': 'Fitri Handayani', 'role': 'QA Engineer', 'avatar': 'FH'},
    {'name': 'Eko Wijaya', 'role': 'Data Scientist', 'avatar': 'EW'},
    {'name': 'Maya Sari', 'role': 'Mobile Developer', 'avatar': 'MS'},
  ];

  static const List<Color> _colors = [
    Color(0xFF6C63FF),
    Color(0xFFFF6B6B),
    Color(0xFF4ECDC4),
    Color(0xFFFF8C42),
    Color(0xFF95E1D3),
    Color(0xFFF38181),
    Color(0xFF3FC1C9),
    Color(0xFFFFE66D),
  ];

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('ListView.builder (${_data.length} item dari array)'),
          const SizedBox(height: 12),
          Expanded(
            child: ListView.builder(
              itemCount: _data.length,
              itemBuilder: (context, index) {
                final item = _data[index];
                final color = _colors[index % _colors.length];
                return Container(
                  margin: const EdgeInsets.only(bottom: 10),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(14),
                    boxShadow: [
                      BoxShadow(
                        color: color.withValues(alpha: 0.15),
                        blurRadius: 8,
                        offset: const Offset(0, 3),
                      ),
                    ],
                  ),
                  child: ListTile(
                    contentPadding:
                        const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    leading: Container(
                      width: 48,
                      height: 48,
                      decoration:
                          BoxDecoration(color: color, shape: BoxShape.circle),
                      alignment: Alignment.center,
                      child: Text(
                        item['avatar']!,
                        style: const TextStyle(
                            color: Colors.white, fontWeight: FontWeight.bold),
                      ),
                    ),
                    title: Text(item['name']!,
                        style: const TextStyle(fontWeight: FontWeight.bold)),
                    subtitle: Text(item['role']!,
                        style: TextStyle(
                            color: color, fontWeight: FontWeight.w500)),
                    trailing: Chip(
                      label: Text('${index + 1}',
                          style: const TextStyle(fontSize: 11)),
                      backgroundColor: color.withValues(alpha: 0.1),
                      side: BorderSide.none,
                    ),
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 5. LISTVIEW.SEPARATED PAGE – list + garis pembatas
// ─────────────────────────────────────────────────────────────
class ListViewSeparatedPage extends StatelessWidget {
  const ListViewSeparatedPage({super.key});

  static const List<Map<String, String>> _menu = [
    {'title': 'Nasi Goreng Spesial', 'price': 'Rp 25.000', 'emoji': '🍳'},
    {'title': 'Mie Ayam Bakso', 'price': 'Rp 20.000', 'emoji': '🍜'},
    {'title': 'Soto Ayam', 'price': 'Rp 18.000', 'emoji': '🥣'},
    {'title': 'Ayam Bakar', 'price': 'Rp 30.000', 'emoji': '🍗'},
    {'title': 'Es Teh Manis', 'price': 'Rp 5.000', 'emoji': '🧋'},
    {'title': 'Jus Alpukat', 'price': 'Rp 12.000', 'emoji': '🥑'},
    {'title': 'Pisang Goreng', 'price': 'Rp 8.000', 'emoji': '🍌'},
  ];

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('ListView.separated (garis pembatas)'),
          const SizedBox(height: 12),
          Expanded(
            child: Container(
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.06),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              clipBehavior: Clip.hardEdge,
              child: ListView.separated(
                itemCount: _menu.length,
                separatorBuilder: (context, index) => const Divider(
                  height: 1,
                  thickness: 1,
                  indent: 72,
                  endIndent: 16,
                  color: Color(0xFFEEEEEE),
                ),
                itemBuilder: (context, index) {
                  final item = _menu[index];
                  return ListTile(
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16, vertical: 8),
                    leading: Container(
                      width: 48,
                      height: 48,
                      decoration: BoxDecoration(
                        color: const Color(0xFFF5F5FF),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      alignment: Alignment.center,
                      child: Text(item['emoji']!,
                          style: const TextStyle(fontSize: 24)),
                    ),
                    title: Text(
                      item['title']!,
                      style: const TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 15),
                    ),
                    trailing: Container(
                      padding: const EdgeInsets.symmetric(
                          horizontal: 10, vertical: 4),
                      decoration: BoxDecoration(
                        color:
                            const Color(0xFF6C63FF).withValues(alpha: 0.1),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        item['price']!,
                        style: const TextStyle(
                          color: Color(0xFF6C63FF),
                          fontWeight: FontWeight.bold,
                          fontSize: 13,
                        ),
                      ),
                    ),
                  );
                },
              ),
            ),
          ),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// 6. STACK PAGE – tampilan bertumpuk
// ─────────────────────────────────────────────────────────────
class StackPage extends StatelessWidget {
  const StackPage({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          sectionTitle('Stack Widget'),
          const SizedBox(height: 16),

          // Stack 1 – overlapping colored boxes
          smallLabel('Stack – Kotak Bertumpuk'),
          const SizedBox(height: 8),
          SizedBox(
            height: 200,
            child: Stack(
              children: [
                Container(
                  width: 160,
                  height: 160,
                  decoration: BoxDecoration(
                    color: const Color(0xFF6C63FF),
                    borderRadius: BorderRadius.circular(16),
                  ),
                ),
                Positioned(
                  left: 40,
                  top: 40,
                  child: Container(
                    width: 160,
                    height: 160,
                    decoration: BoxDecoration(
                      color: const Color(0xFFFF6B6B).withValues(alpha: 0.85),
                      borderRadius: BorderRadius.circular(16),
                    ),
                  ),
                ),
                Positioned(
                  left: 80,
                  top: 80,
                  child: Container(
                    width: 160,
                    height: 160,
                    decoration: BoxDecoration(
                      color: const Color(0xFF4ECDC4).withValues(alpha: 0.85),
                      borderRadius: BorderRadius.circular(16),
                    ),
                    alignment: Alignment.center,
                    child: const Text(
                      'STACK!',
                      style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 22),
                    ),
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 24),

          // Stack 2 – card with badge
          smallLabel('Stack – Card dengan Badge'),
          const SizedBox(height: 16),
          Stack(
            clipBehavior: Clip.none,
            children: [
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(20),
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFF6C63FF), Color(0xFF3FC1C9)],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('Flutter Widget',
                        style:
                            TextStyle(color: Colors.white70, fontSize: 13)),
                    SizedBox(height: 4),
                    Text('Stack Widget Demo',
                        style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                            fontSize: 22)),
                    SizedBox(height: 8),
                    Text('Widget bertumpuk satu di atas yang lain',
                        style: TextStyle(
                            color: Colors.white70, fontSize: 13)),
                  ],
                ),
              ),
              Positioned(
                top: -12,
                right: 20,
                child: Container(
                  padding: const EdgeInsets.symmetric(
                      horizontal: 14, vertical: 6),
                  decoration: BoxDecoration(
                    color: const Color(0xFFFFE66D),
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: 0.15),
                        blurRadius: 8,
                        offset: const Offset(0, 3),
                      ),
                    ],
                  ),
                  child: const Text(
                    '⭐ Featured',
                    style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 12,
                        color: Colors.black87),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 24),

          // Stack 3 – text overlay on box
          smallLabel('Stack – Teks di atas Kotak'),
          const SizedBox(height: 8),
          Stack(
            children: [
              Container(
                width: double.infinity,
                height: 120,
                decoration: BoxDecoration(
                  color: const Color(0xFF2D2D2D),
                  borderRadius: BorderRadius.circular(16),
                ),
              ),
              Positioned.fill(
                child: Container(
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(16),
                    gradient: LinearGradient(
                      colors: [
                        Colors.transparent,
                        Colors.black.withValues(alpha: 0.7)
                      ],
                      begin: Alignment.topCenter,
                      end: Alignment.bottomCenter,
                    ),
                  ),
                ),
              ),
              const Positioned(
                bottom: 16,
                left: 16,
                right: 16,
                child: Text(
                  'Teks di atas lapisan Stack',
                  style: TextStyle(
                      color: Colors.white,
                      fontWeight: FontWeight.bold,
                      fontSize: 18),
                ),
              ),
              const Positioned(
                top: 12,
                right: 12,
                child: Icon(Icons.layers_rounded,
                    color: Colors.white54, size: 28),
              ),
            ],
          ),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────────────────────────
// SHARED HELPERS
// ─────────────────────────────────────────────────────────────
Widget sectionTitle(String title) {
  return Text(
    title,
    style: const TextStyle(
        fontSize: 18, fontWeight: FontWeight.bold, color: Color(0xFF2D2D2D)),
  );
}

Widget smallLabel(String text) {
  return Text(
    text,
    style: const TextStyle(
        fontSize: 14,
        fontWeight: FontWeight.w600,
        color: Color(0xFF6C63FF)),
  );
}
