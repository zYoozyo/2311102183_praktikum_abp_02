# Pertemuan 9 & 10 — Flutter Provider + Firebase FCM

## 📱 Deskripsi Aplikasi

Aplikasi **To-Do List** sederhana yang mengimplementasikan:
- **State Management** menggunakan `Provider` (ChangeNotifier)
- **Firebase Cloud Messaging (FCM)** untuk push notification

---

## 📦 Struktur File

```
todo_provider_fcm/
├── lib/
│   ├── main.dart                    ← Entry point, Firebase init, FCM setup
│   ├── models/
│   │   └── task_model.dart          ← Model data tugas (Task)
│   ├── providers/
│   │   └── task_provider.dart       ← Provider (State Management)
│   └── screens/
│       └── todo_screen.dart         ← Halaman UI utama
├── android/
│   ├── app/
│   │   ├── build.gradle.kts         ← Firebase plugin, minSdk=23
│   │   └── google-services.json     ← ⚠️ WAJIB diisi dari Firebase Console
│   └── settings.gradle.kts          ← Google Services plugin
└── pubspec.yaml                     ← Dependencies
```

---

## ⚙️ Setup Firebase (WAJIB dilakukan manual)

### Langkah 1 — Buat Project Firebase

1. Buka [console.firebase.google.com](https://console.firebase.google.com)
2. Klik **"Add project"** → beri nama (misal: `todo-fcm-app`)
3. Selesaikan wizard setup

### Langkah 2 — Daftarkan Aplikasi Android

1. Di Firebase Console → **Project Overview** → klik icon **Android**
2. Isi **Android package name**: `com.example.todo_provider_fcm`
3. Klik **Register app**
4. **Download** file `google-services.json`

### Langkah 3 — Pasang google-services.json

Letakkan file yang didownload ke:
```
android/app/google-services.json
```
(Ganti file placeholder yang sudah ada)

### Langkah 4 — Aktifkan Cloud Messaging

1. Di Firebase Console → **Build** → **Cloud Messaging**
2. Pastikan sudah diaktifkan

---

## 🚀 Cara Menjalankan Aplikasi

```bash
# Di dalam folder todo_provider_fcm
flutter pub get
flutter run
```

> ⚠️ Pastikan emulator/device Android sudah terhubung

---

## 🔔 Cara Mengirim Notifikasi FCM (Testing)

### Metode 1 — Firebase Console

1. Buka **Firebase Console** → **Cloud Messaging**
2. Klik **"Send your first message"** / **"New notification"**
3. Isi:
   - **Notification title**: `Tugas Baru!`
   - **Notification text**: `Ada tugas yang harus diselesaikan hari ini`
4. Klik **Next** → **Send test message**
5. Masukkan **FCM Token** dari log debug aplikasi
6. Klik **Test**

> 💡 FCM Token muncul di console saat app pertama kali dijalankan:
> ```
> 🔑 FCM Token: eyJhbGci...
> ```

### Metode 2 — Postman (FCM HTTP v1 API)

```
POST https://fcm.googleapis.com/v1/projects/{YOUR_PROJECT_ID}/messages:send

Headers:
  Authorization: Bearer {ACCESS_TOKEN}
  Content-Type: application/json

Body:
{
  "message": {
    "token": "{FCM_TOKEN_DEVICE}",
    "notification": {
      "title": "Tugas Baru!",
      "body": "Ada tugas yang harus diselesaikan"
    }
  }
}
```

---

## 📸 Screenshot yang Diperlukan untuk Laporan

| No | Screenshot | Keterangan |
|----|-----------|-----------|
| 1  | Tampilan daftar tugas | Setelah menambah 3-5 tugas |
| 2  | Proses penambahan tugas | Modal sheet input terbuka |
| 3  | Notifikasi diterima | Notifikasi FCM muncul di status bar |

---

## 🧑‍💻 Penjelasan State Management (Provider)

```dart
// TaskProvider mewarisi ChangeNotifier
class TaskProvider extends ChangeNotifier {
  List<Task> _tasks = [];

  void addTask(String title) {
    _tasks.add(Task(...));
    notifyListeners(); // ← UI otomatis rebuild
  }
}

// Di main.dart, wrap app dengan ChangeNotifierProvider
ChangeNotifierProvider(
  create: (_) => TaskProvider(),
  child: MaterialApp(...),
)

// Di UI, gunakan Consumer untuk listen perubahan
Consumer<TaskProvider>(
  builder: (_, provider, __) => ListView.builder(...)
)
```

---

## 📚 Dependencies yang Digunakan

| Package | Versi | Kegunaan |
|---------|-------|---------|
| `provider` | ^6.1.2 | State Management |
| `firebase_core` | ^3.6.0 | Inisialisasi Firebase |
| `firebase_messaging` | ^15.1.3 | Push Notification FCM |
| `flutter_local_notifications` | ^17.2.4 | Tampilkan notifikasi lokal |
