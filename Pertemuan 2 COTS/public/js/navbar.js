/**
 * public/js/navbar.js — Render navbar & toast container secara dinamis
 * Di-include setelah jQuery & Bootstrap di bagian bawah <body>.
 * Cukup 2 menu: Tabel Data & Tambah Data.
 */

(function () {
  const path = window.location.pathname;

  const navbarHTML = `
  <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/">
        <i class="bi bi-database-fill-gear me-2"></i>DataManager
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link ${path === '/' ? 'active fw-semibold' : ''}" href="/">
              <i class="bi bi-table me-1"></i>Tabel Data
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link ${path === '/tambah' ? 'active fw-semibold' : ''}" href="/tambah">
              <i class="bi bi-plus-circle me-1"></i>Tambah Data
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Toast Container (harus ada di DOM sebelum showToast() dipanggil) -->
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;" id="toastContainer"></div>
  `;

  // Sisipkan navbar di awal <body>
  document.body.insertAdjacentHTML('afterbegin', navbarHTML);
})();
