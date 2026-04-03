/**
 * public/js/tambah.js — Logika halaman Tambah Data
 *
 * - Validasi form dengan jQuery (real-time & on submit)
 * - Counter karakter untuk nama & alamat
 * - POST ke /api/data → redirect ke halaman tabel
 */

$(document).ready(function () {

  // ── Counter Karakter ──────────────────────────────────────────────────────
  $('#nama').on('input', function () {
    $('#ctrNama').text(`${$(this).val().length}/100`);
  });

  $('#alamat').on('input', function () {
    $('#ctrAlamat').text(`${$(this).val().length}/300`);
  });

  // Hanya izinkan digit pada field telepon
  $('#telepon').on('input', function () {
    $(this).val($(this).val().replace(/\D/g, ''));
  });

  // ── Real-time Validation (blur per field) ─────────────────────────────────
  $('#nama').on('blur', () => validateNama());
  $('#email').on('blur', () => validateEmail());
  $('#telepon').on('blur', () => validateTelepon());
  $('#pekerjaan').on('blur', () => validatePekerjaan());
  $('#alamat').on('blur', () => validateAlamat());

  // ── Submit Form ───────────────────────────────────────────────────────────
  $('#formTambah').on('submit', function (e) {
    e.preventDefault();

    // Jalankan semua validasi
    const v1 = validateNama();
    const v2 = validateEmail();
    const v3 = validateTelepon();
    const v4 = validatePekerjaan();
    const v5 = validateAlamat();

    if (!v1 || !v2 || !v3 || !v4 || !v5) return;

    const payload = {
      nama:      $('#nama').val().trim(),
      email:     $('#email').val().trim(),
      telepon:   $('#telepon').val().trim(),
      pekerjaan: $('#pekerjaan').val().trim(),
      alamat:    $('#alamat').val().trim(),
    };

    // Disable tombol saat loading
    $('#btnSubmit').prop('disabled', true).html(
      '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'
    );

    $.ajax({
      url: '/api/data',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(payload),
      success(res) {
        if (res.success) {
          // Simpan pesan ke sessionStorage, tampilkan di halaman tabel
          sessionStorage.setItem('successMsg', 'Data kontak berhasil ditambahkan ✓');
          window.location.href = '/';
        } else {
          showToast(res.message || 'Gagal menyimpan data', 'danger');
          resetBtn();
        }
      },
      error(xhr) {
        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan server';
        showToast(msg, 'danger');
        resetBtn();
      },
    });
  });

  // ── Reset Form ────────────────────────────────────────────────────────────
  $('#btnReset').on('click', function () {
    $('#formTambah')[0].reset();
    ['nama','email','telepon','pekerjaan','alamat'].forEach(clearError);
    $('#ctrNama').text('0/100');
    $('#ctrAlamat').text('0/300');
  });

  // ══════════════════════════════════════════════════════════
  //  FUNGSI VALIDASI
  // ══════════════════════════════════════════════════════════

  function validateNama() {
    const val = $('#nama').val().trim();
    if (val.length < 3) return setError('nama', 'errNama', 'Nama minimal 3 karakter');
    return clearError('nama');
  }

  function validateEmail() {
    const val = $('#email').val().trim();
    const re  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(val)) return setError('email', 'errEmail', 'Format email tidak valid');
    return clearError('email');
  }

  function validateTelepon() {
    const val = $('#telepon').val().trim();
    if (!/^[0-9]{10,13}$/.test(val)) return setError('telepon', 'errTelepon', 'Telepon harus 10–13 digit angka');
    return clearError('telepon');
  }

  function validatePekerjaan() {
    const val = $('#pekerjaan').val().trim();
    if (val.length < 2) return setError('pekerjaan', 'errPekerjaan', 'Pekerjaan wajib diisi (min. 2 karakter)');
    return clearError('pekerjaan');
  }

  function validateAlamat() {
    const val = $('#alamat').val().trim();
    if (val.length < 5) return setError('alamat', 'errAlamat', 'Alamat minimal 5 karakter');
    return clearError('alamat');
  }

  function setError(inputId, errId, msg) {
    $('#' + inputId).addClass('is-invalid').removeClass('is-valid');
    $('#' + errId).text(msg);
    return false;
  }

  function clearError(inputId, errId) {
    $('#' + inputId).removeClass('is-invalid').addClass('is-valid');
    if (errId) $('#' + errId).text('');
    return true;
  }

  function resetBtn() {
    $('#btnSubmit').prop('disabled', false).html(
      '<i class="bi bi-save me-1"></i>Simpan Data'
    );
  }
});
