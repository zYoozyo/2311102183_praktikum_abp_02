/**
 * public/js/tabel.js — Logika halaman Tabel Data
 *
 * - Inisialisasi DataTables dengan AJAX JSON
 * - Render tombol Edit & Hapus di setiap baris
 * - Handle modal Edit: load data → validasi → PUT /api/data/:id
 * - Handle modal Hapus: konfirmasi → DELETE /api/data/:id
 */

$(document).ready(function () {

  // ── Tampilkan toast sukses setelah redirect dari halaman Tambah ────────────
  const successMsg = sessionStorage.getItem('successMsg');
  if (successMsg) {
    showToast(successMsg, 'success');
    sessionStorage.removeItem('successMsg');
  }

  // ── 1. Inisialisasi DataTables ──────────────────────────────────────────────
  const table = $('#dataTable').DataTable({
    ajax: {
      url: '/api/data',
      dataSrc: 'data',
    },
    columns: [
      {
        data: null,
        render: (data, type, row, meta) => meta.row + 1,
        orderable: false,
        searchable: false,
        width: '40px',
      },
      { data: 'nama' },
      {
        data: 'email',
        render: (email) => `<a href="mailto:${email}" class="text-decoration-none text-dark">${email}</a>`,
      },
      { data: 'telepon' },
      {
        data: 'pekerjaan',
        render: (val) => `<span class="badge bg-primary badge-pekerjaan">${val}</span>`,
      },
      {
        data: 'createdAt',
        render: (val) => formatTanggal(val),
      },
      {
        // Kolom aksi: tombol Edit & Hapus
        data: null,
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: (data, type, row) => `
          <button class="btn btn-sm btn-warning action-btn me-1 btn-edit"
            title="Edit" data-id="${row.id}">
            <i class="bi bi-pencil-fill"></i>
          </button>
          <button class="btn btn-sm btn-danger action-btn btn-hapus"
            title="Hapus" data-id="${row.id}" data-nama="${row.nama}">
            <i class="bi bi-trash3-fill"></i>
          </button>`,
      },
    ],
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
    },
    pageLength: 10,
    order: [[5, 'desc']], // Default sort: tgl terbaru
    responsive: true,
  });

  // ── 2. Tombol EDIT — buka modal & isi form ─────────────────────────────────
  $('#dataTable').on('click', '.btn-edit', function () {
    const id = $(this).data('id');

    $.ajax({
      url: `/api/data/${id}`,
      method: 'GET',
      success(res) {
        if (!res.success) return showToast('Gagal memuat data', 'danger');

        const d = res.data;
        $('#editId').val(d.id);
        $('#editNama').val(d.nama);
        $('#editEmail').val(d.email);
        $('#editTelepon').val(d.telepon);
        $('#editPekerjaan').val(d.pekerjaan);
        $('#editAlamat').val(d.alamat);

        // Reset state validasi sebelumnya
        clearEditErrors();

        // Tampilkan modal
        new bootstrap.Modal('#modalEdit').show();
      },
      error() {
        showToast('Gagal memuat data dari server', 'danger');
      },
    });
  });

  // ── 3. Simpan perubahan (PUT) ──────────────────────────────────────────────
  $('#btnSimpanEdit').on('click', function () {
    clearEditErrors();

    // Validasi client-side form edit
    const payload = {
      nama: $('#editNama').val().trim(),
      email: $('#editEmail').val().trim(),
      telepon: $('#editTelepon').val().trim(),
      pekerjaan: $('#editPekerjaan').val().trim(),
      alamat: $('#editAlamat').val().trim(),
    };

    let valid = true;
    if (payload.nama.length < 3) { showEditError('editNama', 'errEditNama', 'Nama minimal 3 karakter'); valid = false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email)) { showEditError('editEmail', 'errEditEmail', 'Format email tidak valid'); valid = false; }
    if (!/^[0-9]{10,13}$/.test(payload.telepon)) { showEditError('editTelepon', 'errEditTelepon', 'Telepon harus 10–13 digit angka'); valid = false; }
    if (payload.pekerjaan.length < 2) { showEditError('editPekerjaan', 'errEditPekerjaan', 'Pekerjaan wajib diisi'); valid = false; }
    if (payload.alamat.length < 5) { showEditError('editAlamat', 'errEditAlamat', 'Alamat minimal 5 karakter'); valid = false; }

    if (!valid) return;

    const id = $('#editId').val();

    $.ajax({
      url: `/api/data/${id}`,
      method: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify(payload),
      success(res) {
        if (res.success) {
          bootstrap.Modal.getInstance('#modalEdit').hide();
          table.ajax.reload(null, false); // Reload tanpa reset halaman
          showToast('Data berhasil diperbarui ✓', 'success');
        } else {
          showToast(res.message || 'Gagal update', 'danger');
        }
      },
      error(xhr) {
        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan server';
        showToast(msg, 'danger');
      },
    });
  });

  // ── 4. Tombol HAPUS — buka modal konfirmasi ────────────────────────────────
  let idHapus = null;

  $('#dataTable').on('click', '.btn-hapus', function () {
    idHapus = $(this).data('id');
    const nama = $(this).data('nama');
    $('#namaHapus').text(nama);
    new bootstrap.Modal('#modalHapus').show();
  });

  // ── 5. Konfirmasi hapus (DELETE) ───────────────────────────────────────────
  $('#btnKonfirmasiHapus').on('click', function () {
    if (!idHapus) return;

    $.ajax({
      url: `/api/data/${idHapus}`,
      method: 'DELETE',
      success(res) {
        bootstrap.Modal.getInstance('#modalHapus').hide();
        if (res.success) {
          table.ajax.reload(null, false);
          showToast('Data berhasil dihapus', 'success');
        } else {
          showToast(res.message || 'Gagal menghapus', 'danger');
        }
        idHapus = null;
      },
      error() {
        showToast('Terjadi kesalahan saat menghapus data', 'danger');
        idHapus = null;
      },
    });
  });

  // ── Helper: validasi error pada modal edit ─────────────────────────────────
  function showEditError(inputId, errId, msg) {
    $('#' + inputId).addClass('is-invalid');
    $('#' + errId).text(msg);
  }

  function clearEditErrors() {
    ['editNama', 'editEmail', 'editTelepon', 'editPekerjaan', 'editAlamat'].forEach((id) => {
      $('#' + id).removeClass('is-invalid');
    });
  }
});
