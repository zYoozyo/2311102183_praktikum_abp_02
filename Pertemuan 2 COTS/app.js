/**
 * app.js — Entry point aplikasi Express
 * Mengatur middleware, routing, dan server
 */

const express = require('express');
const path = require('path');
const dataRoutes = require('./routes/dataRoutes');

const app = express();
const PORT = process.env.PORT || 3000;

// ── Middleware ────────────────────────────────────────────────────────────────
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// ── View Engine ───────────────────────────────────────────────────────────────
app.set('view engine', 'html');
app.engine('html', require('fs').readFile.bind(require('fs')));
app.set('views', path.join(__dirname, 'views'));

// ── Routes ────────────────────────────────────────────────────────────────────
// Halaman utama → tabel data
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'index.html'));
});

// Halaman form tambah data
app.get('/tambah', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'tambah.html'));
});

// API REST routes
app.use('/api/data', dataRoutes);

// ── 404 Handler ───────────────────────────────────────────────────────────────
app.use((req, res) => {
  res.status(404).json({ success: false, message: 'Endpoint tidak ditemukan' });
});

// ── Start Server ──────────────────────────────────────────────────────────────
app.listen(PORT, () => {
  console.log(`Server berjalan di http://localhost:${PORT}`);
});

module.exports = app;
