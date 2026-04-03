/**
 * public/js/helpers.js — Fungsi utilitas bersama
 * Dipakai oleh semua halaman: toast notifikasi, format tanggal, dll.
 */

// ── Toast Notification ────────────────────────────────────────────────────────
/**
 * Tampilkan notifikasi toast Bootstrap
 * @param {string} message  - Pesan yang ditampilkan
 * @param {'success'|'danger'|'warning'|'info'} type - Tipe toast
 */
function showToast(message, type = 'success') {
  const icons = {
    success: 'bi-check-circle-fill',
    danger:  'bi-x-circle-fill',
    warning: 'bi-exclamation-triangle-fill',
    info:    'bi-info-circle-fill',
  };

  const id   = 'toast-' + Date.now();
  const icon = icons[type] || icons.info;

  const toastHTML = `
    <div id="${id}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi ${icon} me-2"></i>${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>`;

  $('#toastContainer').append(toastHTML);
  const toastEl = document.getElementById(id);
  const toast   = new bootstrap.Toast(toastEl, { delay: 3500 });
  toast.show();

  // Bersihkan DOM setelah toast hilang
  toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}

// ── Format Tanggal ────────────────────────────────────────────────────────────
/**
 * Format ISO date string ke format Indonesia
 * @param {string} isoString
 * @returns {string}
 */
function formatTanggal(isoString) {
  if (!isoString) return '-';
  const d = new Date(isoString);
  return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
}
