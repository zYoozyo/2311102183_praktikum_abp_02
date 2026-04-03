/**
 * controllers/DataController.js — Controller CRUD
 * Menangani logika bisnis & validasi setiap endpoint API
 */

const DataModel = require('../models/DataModel');

const DataController = {

  // GET /api/data — Ambil semua data
  index(req, res) {
    try {
      const data = DataModel.getAll();
      res.json({
        success: true,
        total: data.length,
        data,
      });
    } catch (err) {
      res.status(500).json({ success: false, message: 'Gagal mengambil data', error: err.message });
    }
  },

  // GET /api/data/:id — Ambil satu data
  show(req, res) {
    try {
      const item = DataModel.findById(req.params.id);
      if (!item) {
        return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
      }
      res.json({ success: true, data: item });
    } catch (err) {
      res.status(500).json({ success: false, message: 'Gagal mengambil data', error: err.message });
    }
  },

  // POST /api/data — Tambah data baru
  store(req, res) {
    try {
      const { nama, email, telepon, alamat, pekerjaan } = req.body;

      // Validasi server-side
      const errors = [];
      if (!nama || nama.trim().length < 3) errors.push('Nama minimal 3 karakter');
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Format email tidak valid');
      if (!telepon || !/^[0-9]{10,13}$/.test(telepon)) errors.push('Telepon harus 10–13 digit angka');
      if (!alamat || alamat.trim().length < 5) errors.push('Alamat minimal 5 karakter');
      if (!pekerjaan || pekerjaan.trim().length < 2) errors.push('Pekerjaan wajib diisi');

      if (errors.length > 0) {
        return res.status(422).json({ success: false, message: 'Validasi gagal', errors });
      }

      // Cek duplikat email
      const existing = DataModel.getAll().find((d) => d.email === email.trim());
      if (existing) {
        return res.status(422).json({ success: false, message: 'Email sudah terdaftar' });
      }

      const newItem = DataModel.create({ nama: nama.trim(), email: email.trim(), telepon: telepon.trim(), alamat: alamat.trim(), pekerjaan: pekerjaan.trim() });
      res.status(201).json({ success: true, message: 'Data berhasil ditambahkan', data: newItem });
    } catch (err) {
      res.status(500).json({ success: false, message: 'Gagal menambahkan data', error: err.message });
    }
  },

  // PUT /api/data/:id — Update data
  update(req, res) {
    try {
      const { nama, email, telepon, alamat, pekerjaan } = req.body;
      const { id } = req.params;

      // Cek apakah data ada
      const existing = DataModel.findById(id);
      if (!existing) {
        return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
      }

      // Validasi
      const errors = [];
      if (!nama || nama.trim().length < 3) errors.push('Nama minimal 3 karakter');
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Format email tidak valid');
      if (!telepon || !/^[0-9]{10,13}$/.test(telepon)) errors.push('Telepon harus 10–13 digit angka');
      if (!alamat || alamat.trim().length < 5) errors.push('Alamat minimal 5 karakter');
      if (!pekerjaan || pekerjaan.trim().length < 2) errors.push('Pekerjaan wajib diisi');

      if (errors.length > 0) {
        return res.status(422).json({ success: false, message: 'Validasi gagal', errors });
      }

      // Cek duplikat email (kecuali data sendiri)
      const duplicate = DataModel.getAll().find((d) => d.email === email.trim() && d.id !== id);
      if (duplicate) {
        return res.status(422).json({ success: false, message: 'Email sudah digunakan data lain' });
      }

      const updated = DataModel.update(id, { nama: nama.trim(), email: email.trim(), telepon: telepon.trim(), alamat: alamat.trim(), pekerjaan: pekerjaan.trim() });
      res.json({ success: true, message: 'Data berhasil diupdate', data: updated });
    } catch (err) {
      res.status(500).json({ success: false, message: 'Gagal mengupdate data', error: err.message });
    }
  },

  // DELETE /api/data/:id — Hapus data
  destroy(req, res) {
    try {
      const deleted = DataModel.delete(req.params.id);
      if (!deleted) {
        return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
      }
      res.json({ success: true, message: 'Data berhasil dihapus' });
    } catch (err) {
      res.status(500).json({ success: false, message: 'Gagal menghapus data', error: err.message });
    }
  },
};

module.exports = DataController;
