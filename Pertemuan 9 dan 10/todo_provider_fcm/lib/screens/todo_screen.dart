import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/task_provider.dart';

class TodoScreen extends StatefulWidget {
  const TodoScreen({super.key});

  @override
  State<TodoScreen> createState() => _TodoScreenState();
}

class _TodoScreenState extends State<TodoScreen>
    with SingleTickerProviderStateMixin {
  final TextEditingController _taskController = TextEditingController();
  late AnimationController _fabAnimController;
  late Animation<double> _fabScaleAnim;

  @override
  void initState() {
    super.initState();
    _fabAnimController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 200),
    );
    _fabScaleAnim = Tween<double>(begin: 1.0, end: 0.85).animate(
      CurvedAnimation(parent: _fabAnimController, curve: Curves.easeInOut),
    );
  }

  @override
  void dispose() {
    _taskController.dispose();
    _fabAnimController.dispose();
    super.dispose();
  }

  void _showAddTaskDialog(BuildContext context) {
    _taskController.clear();
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (ctx) => _buildAddTaskSheet(ctx),
    );
  }

  Widget _buildAddTaskSheet(BuildContext ctx) {
    return Padding(
      padding: EdgeInsets.only(
        bottom: MediaQuery.of(ctx).viewInsets.bottom,
      ),
      child: Container(
        decoration: const BoxDecoration(
          color: Color(0xFF1E1E2E),
          borderRadius: BorderRadius.vertical(top: Radius.circular(28)),
        ),
        padding: const EdgeInsets.fromLTRB(24, 20, 24, 32),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Center(
              child: Container(
                width: 40,
                height: 4,
                decoration: BoxDecoration(
                  color: Colors.white24,
                  borderRadius: BorderRadius.circular(2),
                ),
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              'Tambah Tugas Baru',
              style: TextStyle(
                color: Colors.white,
                fontSize: 20,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _taskController,
              autofocus: true,
              style: const TextStyle(color: Colors.white),
              decoration: InputDecoration(
                hintText: 'Masukkan nama tugas...',
                hintStyle: const TextStyle(color: Colors.white38),
                filled: true,
                fillColor: const Color(0xFF2A2A3E),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(14),
                  borderSide: BorderSide.none,
                ),
                focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(14),
                  borderSide: const BorderSide(
                    color: Color(0xFF7C6FF7),
                    width: 2,
                  ),
                ),
                prefixIcon: const Icon(
                  Icons.task_alt_rounded,
                  color: Color(0xFF7C6FF7),
                ),
              ),
              onSubmitted: (_) => _submitTask(ctx),
            ),
            const SizedBox(height: 20),
            SizedBox(
              width: double.infinity,
              height: 52,
              child: ElevatedButton(
                onPressed: () => _submitTask(ctx),
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFF7C6FF7),
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(14),
                  ),
                  elevation: 0,
                ),
                child: const Text(
                  'Simpan Tugas',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _submitTask(BuildContext ctx) {
    final title = _taskController.text;
    if (title.trim().isNotEmpty) {
      context.read<TaskProvider>().addTask(title);
      Navigator.pop(ctx);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: const Row(
            children: [
              Icon(Icons.check_circle, color: Colors.white),
              SizedBox(width: 8),
              Text('Tugas berhasil ditambahkan!'),
            ],
          ),
          backgroundColor: const Color(0xFF7C6FF7),
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          duration: const Duration(seconds: 2),
        ),
      );
    }
  }

  void _confirmClearAll(BuildContext context) {
    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: const Color(0xFF1E1E2E),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: const Text(
          'Hapus Semua Tugas?',
          style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
        ),
        content: const Text(
          'Semua tugas akan dihapus secara permanen.',
          style: TextStyle(color: Colors.white60),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(ctx),
            child: const Text(
              'Batal',
              style: TextStyle(color: Colors.white60),
            ),
          ),
          ElevatedButton(
            onPressed: () {
              context.read<TaskProvider>().clearAllTasks();
              Navigator.pop(ctx);
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.redAccent,
              foregroundColor: Colors.white,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
            child: const Text('Hapus Semua'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0F0F1A),
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        elevation: 0,
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Daftar Tugas',
              style: TextStyle(
                color: Colors.white,
                fontSize: 22,
                fontWeight: FontWeight.bold,
              ),
            ),
            Consumer<TaskProvider>(
              builder: (_, provider, __) => Text(
                '${provider.completedCount}/${provider.taskCount} selesai',
                style: const TextStyle(
                  color: Colors.white54,
                  fontSize: 13,
                ),
              ),
            ),
          ],
        ),
        actions: [
          Consumer<TaskProvider>(
            builder: (_, provider, __) => provider.taskCount > 0
                ? IconButton(
                    tooltip: 'Hapus Semua',
                    onPressed: () => _confirmClearAll(context),
                    icon: const Icon(
                      Icons.delete_sweep_rounded,
                      color: Colors.redAccent,
                      size: 28,
                    ),
                  )
                : const SizedBox.shrink(),
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: Consumer<TaskProvider>(
        builder: (_, provider, __) {
          if (provider.taskCount == 0) {
            return _buildEmptyState();
          }
          return _buildTaskList(provider);
        },
      ),
      floatingActionButton: ScaleTransition(
        scale: _fabScaleAnim,
        child: FloatingActionButton.extended(
          onPressed: () => _showAddTaskDialog(context),
          backgroundColor: const Color(0xFF7C6FF7),
          foregroundColor: Colors.white,
          icon: const Icon(Icons.add_rounded, size: 28),
          label: const Text(
            'Tambah Tugas',
            style: TextStyle(fontWeight: FontWeight.bold),
          ),
          elevation: 8,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
          ),
        ),
      ),
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 120,
            height: 120,
            decoration: BoxDecoration(
              color: const Color(0xFF1E1E2E),
              shape: BoxShape.circle,
              boxShadow: [
                BoxShadow(
                  color: const Color(0xFF7C6FF7).withOpacity(0.3),
                  blurRadius: 30,
                  spreadRadius: 5,
                ),
              ],
            ),
            child: const Icon(
              Icons.checklist_rounded,
              size: 60,
              color: Color(0xFF7C6FF7),
            ),
          ),
          const SizedBox(height: 24),
          const Text(
            'Belum Ada Tugas',
            style: TextStyle(
              color: Colors.white,
              fontSize: 22,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 8),
          const Text(
            'Tap tombol di bawah untuk menambahkan\ntugas pertama Anda!',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: Colors.white38,
              fontSize: 14,
              height: 1.6,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTaskList(TaskProvider provider) {
    return ListView.builder(
      padding: const EdgeInsets.fromLTRB(16, 8, 16, 100),
      itemCount: provider.tasks.length,
      itemBuilder: (_, index) {
        final task = provider.tasks[index];
        return _buildTaskCard(task, provider);
      },
    );
  }

  Widget _buildTaskCard(task, TaskProvider provider) {
    return AnimatedContainer(
      duration: const Duration(milliseconds: 300),
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: task.isDone
            ? const Color(0xFF1A2A1A)
            : const Color(0xFF1E1E2E),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: task.isDone
              ? Colors.greenAccent.withOpacity(0.3)
              : const Color(0xFF7C6FF7).withOpacity(0.2),
          width: 1,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.2),
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: ListTile(
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
        leading: GestureDetector(
          onTap: () => provider.toggleTask(task.id),
          child: AnimatedContainer(
            duration: const Duration(milliseconds: 200),
            width: 28,
            height: 28,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: task.isDone
                  ? Colors.greenAccent
                  : Colors.transparent,
              border: Border.all(
                color: task.isDone
                    ? Colors.greenAccent
                    : const Color(0xFF7C6FF7),
                width: 2,
              ),
            ),
            child: task.isDone
                ? const Icon(Icons.check, size: 16, color: Colors.black)
                : null,
          ),
        ),
        title: Text(
          task.title,
          style: TextStyle(
            color: task.isDone ? Colors.white38 : Colors.white,
            fontSize: 16,
            fontWeight: FontWeight.w500,
            decoration: task.isDone
                ? TextDecoration.lineThrough
                : TextDecoration.none,
            decorationColor: Colors.white38,
          ),
        ),
        subtitle: Text(
          task.isDone ? 'Selesai ✓' : 'Tap lingkaran untuk selesaikan',
          style: TextStyle(
            color: task.isDone ? Colors.greenAccent.withOpacity(0.6) : Colors.white24,
            fontSize: 12,
          ),
        ),
        trailing: IconButton(
          onPressed: () => provider.deleteTask(task.id),
          icon: const Icon(
            Icons.delete_outline_rounded,
            color: Colors.white30,
            size: 22,
          ),
        ),
      ),
    );
  }
}
