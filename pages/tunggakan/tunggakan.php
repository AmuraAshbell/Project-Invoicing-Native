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
            <h3 class="mb-0">Tabel Tunggakan</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="dashboard.php">Beranda</a></li>
              <li class="breadcrumb-item active">Tabel Tunggakan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tunggakan Pelanggan</h3>
          </div>
          <div class="card-body">

            <!-- Search -->
            <div class="row g-2 mb-3">
              <div class="col-12 col-md-5">
                <label for="search-nama" class="form-label form-label-sm mb-1">Nama Pelanggan</label>
                <input type="text" id="search-nama" class="form-control form-control-sm" placeholder="Cari nama pelanggan...">
              </div>
              <div class="col-12 col-md-4">
                <label for="search-sisa" class="form-label form-label-sm mb-1">Tampilkan</label>
                <select id="search-sisa" class="form-select form-select-sm">
                  <option value="">Semua</option>
                  <option value="ada">Ada Tunggakan</option>
                  <option value="lunas">Lunas</option>
                </select>
              </div>
              <div class="col-12 col-md-3 d-flex align-items-end gap-1">
                <button id="btn-search" type="button" class="btn btn-sm btn-primary w-100">
                  <i class="bi bi-search me-1"></i>Cari
                </button>
                <button id="btn-reset" type="button" class="btn btn-sm btn-outline-secondary w-100" title="Reset">
                  <i class="bi bi-arrow-counterclockwise"></i>
                </button>
              </div>
            </div>

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

    // ── Data Dummy ──
    const dataTunggakan = [
      { nama: 'Amelia Price',    total_inv: 650000,  terbayar: 650000  },
      { nama: 'Budi Santoso',    total_inv: 1560000, terbayar: 800000  },
      { nama: 'Citra Dewi',      total_inv: 1200000, terbayar: 1200000 },
      { nama: 'Daniel Wijaya',   total_inv: 620000,  terbayar: 0       },
      { nama: 'Eka Putri',       total_inv: 3950000, terbayar: 3950000 },
      { nama: 'Fahmi Malik',     total_inv: 1080000, terbayar: 500000  },
      { nama: 'Gita Permata',    total_inv: 1450000, terbayar: 1450000 },
      { nama: 'Hendra Wijaya',   total_inv: 1160000, terbayar: 300000  },
      { nama: 'Indah Lestari',   total_inv: 1100000, terbayar: 1100000 },
      { nama: 'Joko Anwar',      total_inv: 680000,  terbayar: 0       },
    ];

    // ── Custom formatter: hitung sisa tagihan secara dinamis ──
    const sisaTagihanFormatter = (cell) => {
      const data = cell.getRow().getData();
      const sisa = data.total_inv - data.terbayar;

      if (sisa > 0) {
        return `<span class="fw-bold text-danger">${fmt(sisa)}</span>`;
      }
      return `<span class="text-success">${fmt(sisa)}</span>`;
    };

    document.addEventListener('DOMContentLoaded', () => {
      tabelTunggakan = new Tabulator('#users-table', {
        theme: 'bootstrap5',
        data: dataTunggakan,
        layout: 'fitColumns',
        pagination: true,
        paginationSize: 10,
        columns: [
          { title: 'Nama Pelanggan',   field: 'nama' },
          {
            title: 'Total Tagihan', field: 'total_inv', hozAlign: 'right', headerHozAlign:'right', 
            formatter: (cell) => fmt(cell.getValue()),
          },
          {
            title: 'Total Terbayar', field: 'terbayar', hozAlign: 'right', headerHozAlign:'right',
            formatter: (cell) => fmt(cell.getValue()),
          },
          {
            title: 'Sisa Tagihan', field: 'total_inv', hozAlign: 'right', headerHozAlign:'right',
            formatter: sisaTagihanFormatter,
          },
        ],
      });
    });

      function applySearch() {
        const nama = document.getElementById('search-nama').value.trim();
        const sisa = document.getElementById('search-sisa').value;
        tabelTunggakan.setFilter((row) => {
          let ok = true;
          if (nama) ok = ok && row.nama.toLowerCase().includes(nama.toLowerCase());
          if (sisa === 'ada')   ok = ok && (row.total_inv - row.terbayar) > 0;
          if (sisa === 'lunas') ok = ok && (row.total_inv - row.terbayar) <= 0;
          return ok;
        });
      }
      document.getElementById('btn-search').addEventListener('click', applySearch);
      document.getElementById('search-nama').addEventListener('input', applySearch);
      document.getElementById('search-sisa').addEventListener('change', applySearch);
      document.getElementById('btn-reset').addEventListener('click', () => {
        document.getElementById('search-nama').value = '';
        document.getElementById('search-sisa').value = '';
        tabelTunggakan.clearFilter();
      });
  </script>
</body>
</html>