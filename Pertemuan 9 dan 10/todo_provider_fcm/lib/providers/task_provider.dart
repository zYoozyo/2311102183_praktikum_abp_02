import 'package:flutter/foundation.dart';
import '../models/task_model.dart';

class TaskProvider extends ChangeNotifier {
  final List<Task> _tasks = [];

  List<Task> get tasks => List.unmodifiable(_tasks);

  int get taskCount => _tasks.length;
  int get completedCount => _tasks.where((t) => t.isDone).length;

  void addTask(String title) {
    if (title.trim().isEmpty) return;
    _tasks.add(Task(
      id: DateTime.now().millisecondsSinceEpoch.toString(),
      title: title.trim(),
    ));
    notifyListeners();
  }

  void toggleTask(String id) {
    final index = _tasks.indexWhere((t) => t.id == id);
    if (index != -1) {
      _tasks[index].isDone = !_tasks[index].isDone;
      notifyListeners();
    }
  }

  void deleteTask(String id) {
    _tasks.removeWhere((t) => t.id == id);
    notifyListeners();
  }

  void clearAllTasks() {
    _tasks.clear();
    notifyListeners();
  }
}
