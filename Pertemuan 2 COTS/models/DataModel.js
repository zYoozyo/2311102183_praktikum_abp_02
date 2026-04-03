/**
 * models/DataModel.js — Model data (in-memory storage)
 * Menyimpan & mengelola data kontak di memori (array)
 * Bisa diganti dengan database nyata (MySQL, MongoDB, dll)
 */

const { v4: uuidv4 } = require('uuid');

// Seed data awal agar tabel tidak kosong saat pertama dibuka
let dataStore = [
  {
    id: uuidv4(),
    nama: 'Muhammad Ragiel Prastyo',
    email: 'suuiiiiii@email.com',
    telepon: '2311102183',
    alamat: 'jalan jalan',
    pekerjaan: 'Design Graphic',
    createdAt: new Date('2026-03-27').toISOString(),
  },
];

const DataModel = {
  // Ambil semua data
  getAll() {
    return dataStore;
  },

  // Cari data berdasarkan ID
  findById(id) {
    return dataStore.find((item) => item.id === id) || null;
  },

  // Tambah data baru
  create(payload) {
    const newItem = {
      id: uuidv4(),
      nama: payload.nama,
      email: payload.email,
      telepon: payload.telepon,
      alamat: payload.alamat,
      pekerjaan: payload.pekerjaan,
      createdAt: new Date().toISOString(),
    };
    dataStore.push(newItem);
    return newItem;
  },

  // Update data berdasarkan ID
  update(id, payload) {
    const index = dataStore.findIndex((item) => item.id === id);
    if (index === -1) return null;

    dataStore[index] = {
      ...dataStore[index],
      nama: payload.nama,
      email: payload.email,
      telepon: payload.telepon,
      alamat: payload.alamat,
      pekerjaan: payload.pekerjaan,
      updatedAt: new Date().toISOString(),
    };
    return dataStore[index];
  },

  // Hapus data berdasarkan ID
  delete(id) {
    const index = dataStore.findIndex((item) => item.id === id);
    if (index === -1) return false;
    dataStore.splice(index, 1);
    return true;
  },
};

module.exports = DataModel;
