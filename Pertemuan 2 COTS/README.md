# DataManager — Aplikasi CRUD Node.js + Bootstrap + DataTables

## Cara Menjalankan

```bash
cd crud-app
npm install
node app.js
# Buka: http://localhost:3000
```

## Struktur Folder

```
crud-app/
├── app.js                    ← Entry point Express
├── package.json
├── models/
│   └── DataModel.js          ← Layer data (in-memory)
├── controllers/
│   └── DataController.js     ← Logika bisnis + validasi
├── routes/
│   └── dataRoutes.js         ← Mapping endpoint ke Controller
├── views/
│   ├── index.html            ← Halaman Tabel Data + Modal Edit/Hapus
│   └── tambah.html           ← Halaman Form Input
└── public/js/
    ├── navbar.js             ← Navbar Bootstrap dinamis (shared)
    ├── helpers.js            ← showToast(), formatTanggal()
    ├── tabel.js              ← DataTables AJAX + CRUD handler
    └── tambah.js             ← Validasi form jQuery + POST AJAX
```

## API Endpoints

| Method   | Endpoint        | Fungsi           |
|----------|-----------------|------------------|
| GET      | `/api/data`     | Ambil semua data |
| GET      | `/api/data/:id` | Ambil satu data  |
| POST     | `/api/data`     | Tambah data baru |
| PUT      | `/api/data/:id` | Update data      |
| DELETE   | `/api/data/:id` | Hapus data       |
