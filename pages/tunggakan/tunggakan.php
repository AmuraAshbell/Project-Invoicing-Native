<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tunggakan</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/css/tabulator_bootstrap5.min.css" crossorigin="anonymous"/>
</head>
<body class="app-wrapper">
<?php include "../../layout/navbar.php"; ?>
<?php include "../../layout/sidebar.php"; ?>

  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Tunggakan</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
              <li class="breadcrumb-item active">Tunggakan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Tunggakan Pelanggan</h3>
          </div>
          <div class="card-body">

            <!-- Search -->
            <div class="row g-2 mb-3">
              <div class="col-12 col-md-8">
                <label for="search-nama" class="form-label form-label-sm mb-1">Nama Pelanggan</label>
                <input type="text" id="search-nama" class="form-control form-control-sm" placeholder="Cari nama pelanggan...">
              </div>
              <div class="col-12 col-md-4 d-flex align-items-end gap-1">
                <button id="btn-search" type="button" class="btn btn-sm btn-primary w-100">
                  <i class="bi bi-search me-1"></i>Cari
                </button>
                <button id="btn-reset" type="button" class="btn btn-sm btn-outline-secondary w-100" title="Reset">
                  <i class="bi bi-arrow-counterclockwise"></i>
                </button>
              </div>
            </div>

            <p class="text-secondary small mb-2">
              <i class="bi bi-info-circle me-1"></i>Hanya menampilkan faktur yang masih memiliki sisa tagihan. Faktur yang sudah lunas atau dibatalkan otomatis tidak tercantum di sini.
            </p>

            <div id="users-table"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../../layout/footer.php"; ?>


  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="../../dist/js/adminlte.js"></script>
  <script src="../../assets/js/dummy-data.js"></script>

  <script>
    (() => {
      'use strict';
      const STORAGE_KEY = 'lte-theme';
      const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
      const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
      const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
      const getPreferredTheme = () => { const stored = getStoredTheme(); if (stored) return stored; return prefersDark() ? 'dark' : 'light'; };
      const setTheme = (theme) => { const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme; document.documentElement.setAttribute('data-bs-theme', resolved); };
      setTheme(getPreferredTheme());
      const showActiveTheme = (theme) => {
        document.querySelectorAll('[data-bs-theme-value]').forEach((el) => { el.classList.remove('active'); el.setAttribute('aria-pressed', 'false'); const check = el.querySelector('.bi-check-lg'); if (check) check.classList.add('d-none'); });
        const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
        if (active) { active.classList.add('active'); active.setAttribute('aria-pressed', 'true'); const check = active.querySelector('.bi-check-lg'); if (check) check.classList.remove('d-none'); }
        document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => { icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme); });
      };
      globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => { const stored = getStoredTheme(); if (!stored || stored === 'auto') setTheme(getPreferredTheme()); });
      document.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme());
        document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => { toggle.addEventListener('click', () => { const theme = toggle.getAttribute('data-bs-theme-value'); setStoredTheme(theme); setTheme(theme); showActiveTheme(theme); }); });
      });
    })();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
  <script>
    let tabelTunggakan;
    const fmt = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

    // ── Satu baris = satu faktur (bukan agregat per pelanggan lagi) ──
    // Supaya "No. Faktur" bisa ditampilkan langsung dan jelas faktur mana
    // yang jadi sumber tunggakannya. Faktur yang batal atau sudah lunas
    // (sisa Rp0) otomatis tidak ikut tampil di sini.
    const dataTunggakan = DummyDB.getInvoices()
      .filter((inv) => inv.status !== 'cancelled' && inv.sisa > 0);

    document.addEventListener('DOMContentLoaded', () => {
      tabelTunggakan = new Tabulator('#users-table', {
        theme: 'bootstrap5',
        data: dataTunggakan,
        layout: 'fitColumns',
        pagination: true,
        paginationSize: 10,

        paginationCounter: function(pageSize, currentRow, currentPage, totalRows, totalPages) {
            // Mengambil total seluruh data asli (sebelum terkena filter/pencarian)
            const totalDataKeseluruhan = tabelTunggakan.getData().length;
            
            // Format output sesuai permintaanmu
            return `Menampilkan ${pageSize} Data dari ${totalRows} Data, Total Data adalah ${totalDataKeseluruhan}`;
        },

        columns: [
          { title: 'No', formatter: 'rownum', hozAlign: 'center', headerHozAlign: 'center', headerSort: false, width: 60 },
          { title: 'No. Faktur', field: 'inv_no', headerHozAlign: 'center', hozAlign: 'center' },
          { title: 'Nama Pelanggan', field: 'customer' },
          {
            title: 'Total Tagihan', field: 'total', hozAlign: 'right', headerHozAlign:'right',
            formatter: (cell) => fmt(cell.getValue()),
          },
          {
            title: 'Total Terbayar', field: 'terbayar', hozAlign: 'right', headerHozAlign:'right',
            formatter: (cell) => fmt(cell.getValue()),
          },
          {
            title: 'Sisa Tagihan', field: 'sisa', hozAlign: 'right', headerHozAlign:'right',
            formatter: (cell) => `<span class="fw-bold text-danger">${fmt(cell.getValue())}</span>`,
          },
          {
            title: 'Aksi', hozAlign: 'center', headerHozAlign: 'center', headerSort: false, width: 130,
            formatter: () => `<button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye me-1"></i>Detail</button>`,
            cellClick: (e, cell) => {
              const invNo = cell.getRow().getData().inv_no;
              window.location.href = `../invoice/invoice.php?inv_no=${encodeURIComponent(invNo)}`;
            },
          },
        ],
      });
    });

      function applySearch() {
        const kata = document.getElementById('search-nama').value.trim().toLowerCase();
        tabelTunggakan.setFilter((row) =>
          !kata ||
          row.customer.toLowerCase().includes(kata) ||
          row.inv_no.toLowerCase().includes(kata)
        );
      }
      document.getElementById('btn-search').addEventListener('click', applySearch);
      document.getElementById('search-nama').addEventListener('input', applySearch);
      document.getElementById('btn-reset').addEventListener('click', () => {
        document.getElementById('search-nama').value = '';
        tabelTunggakan.clearFilter();
      });
  </script>
</body>
</html>