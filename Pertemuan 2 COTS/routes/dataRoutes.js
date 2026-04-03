/**
 * routes/dataRoutes.js — Definisi API Endpoints
 * Menghubungkan URL dengan method di Controller
 *
 *  GET    /api/data       → index  (ambil semua)
 *  GET    /api/data/:id   → show   (ambil satu)
 *  POST   /api/data       → store  (tambah)
 *  PUT    /api/data/:id   → update (edit)
 *  DELETE /api/data/:id   → destroy (hapus)
 */

const express    = require('express');
const router     = express.Router();
const DataController = require('../controllers/DataController');

router.get('/',     DataController.index);
router.get('/:id',  DataController.show);
router.post('/',    DataController.store);
router.put('/:id',  DataController.update);
router.delete('/:id', DataController.destroy);

module.exports = router;
