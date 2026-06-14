import 'package:flutter/material.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:provider/provider.dart';
import 'providers/task_provider.dart';
import 'screens/todo_screen.dart';

// ============================================================
// Handler untuk notifikasi FCM saat app di background/terminated
// HARUS di luar class (top-level function)
// ============================================================
@pragma('vm:entry-point')
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
  debugPrint('📩 Background message: ${message.messageId}');
}

// ============================================================
// Setup Flutter Local Notifications
// ============================================================
final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
    FlutterLocalNotificationsPlugin();

const AndroidNotificationChannel channel = AndroidNotificationChannel(
  'high_importance_channel',
  'High Importance Notifications',
  description: 'Channel untuk notifikasi FCM penting.',
  importance: Importance.high,
);

Future<void> _setupLocalNotifications() async {
  const AndroidInitializationSettings androidInit =
      AndroidInitializationSettings('@mipmap/ic_launcher');

  const InitializationSettings initSettings =
      InitializationSettings(android: androidInit);

  await flutterLocalNotificationsPlugin.initialize(initSettings);

  await flutterLocalNotificationsPlugin
      .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin>()
      ?.createNotificationChannel(channel);
}

// ============================================================
// Setup FCM Listener (Foreground)
// ============================================================
Future<void> _setupFCMListeners() async {
  FirebaseMessaging messaging = FirebaseMessaging.instance;

  // Minta izin notifikasi
  NotificationSettings settings = await messaging.requestPermission(
    alert: true,
    badge: true,
    sound: true,
  );

  debugPrint('📋 Permission status: ${settings.authorizationStatus}');

  // Dapatkan FCM Token (untuk testing via Postman/Firebase Console)
  String? token = await messaging.getToken();
  debugPrint('🔑 FCM Token: $token');

  // Listener saat app FOREGROUND
  FirebaseMessaging.onMessage.listen((RemoteMessage message) {
    debugPrint('📩 Foreground message: ${message.notification?.title}');

    RemoteNotification? notification = message.notification;
    AndroidNotification? android = message.notification?.android;

    if (notification != null && android != null) {
      flutterLocalNotificationsPlugin.show(
        notification.hashCode,
        notification.title,
        notification.body,
        NotificationDetails(
          android: AndroidNotificationDetails(
            channel.id,
            channel.name,
            channelDescription: channel.description,
            importance: Importance.high,
            priority: Priority.high,
            icon: '@mipmap/ic_launcher',
            color: const Color(0xFF7C6FF7),
          ),
        ),
      );
    }
  });

  // Listener saat app dibuka dari notifikasi background
  FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
    debugPrint('🚀 App opened from notification: ${message.notification?.title}');
  });
}

// ============================================================
// Main Entry Point
// ============================================================
void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Inisialisasi Firebase
  await Firebase.initializeApp();

  // Daftarkan background handler
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  // Setup local notifications
  await _setupLocalNotifications();

  // Setup FCM listeners
  await _setupFCMListeners();

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => TaskProvider(),
      child: MaterialApp(
        title: 'Todo Provider + FCM',
        debugShowCheckedModeBanner: false,
        theme: ThemeData.dark().copyWith(
          scaffoldBackgroundColor: const Color(0xFF0F0F1A),
          colorScheme: const ColorScheme.dark(
            primary: Color(0xFF7C6FF7),
            secondary: Color(0xFF7C6FF7),
          ),
        ),
        home: const TodoScreen(),
      ),
    );
  }
}
