<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="../../style/index.css">
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
            <h3 class="mb-0">Data Pembayaran</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="dashboard.php">Beranda</a></li>
              <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Pembayaran</h3>
          </div>
          <div class="card-body">

            <!-- ── Form Pencarian ── -->
            <div class="row g-2 mb-3">
              <div class="col-12 col-md-4">
                <label for="search-keyword" class="form-label form-label-sm mb-1">Kata Kunci</label>
                <input type="text" id="search-keyword" class="form-control form-control-sm" placeholder="Cari No. Faktur...">
              </div>
              <div class="col-6 col-md-3">
                <label for="search-date-from" class="form-label form-label-sm mb-1">Tgl Dari</label>
                <input type="date" id="search-date-from" class="form-control form-control-sm">
              </div>
              <div class="col-6 col-md-3">
                <label for="search-date-to" class="form-label form-label-sm mb-1">Tgl Ke</label>
                <input type="date" id="search-date-to" class="form-control form-control-sm">
              </div>
              <div class="col-12 col-md-2 d-flex align-items-end">
                <button id="btn-reset" type="button" class="btn btn-sm btn-outline-secondary w-100">
                  <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
              </div>
            </div>

            <!-- ── Tabel Pembayaran ── -->
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
  <script src="dist/js/adminlte.js"></script>

  <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined && !isMobile) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>

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
    const fmt = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

    // ── Data Dummy ──
    const dataPembayaran = [
      { no: 1,  tanggal: '2026-06-23', inv_no: 'INV-2026-001', nominal: 650000  },
      { no: 2,  tanggal: '2026-06-24', inv_no: 'INV-2026-002', nominal: 1560000 },
      { no: 3,  tanggal: '2026-06-25', inv_no: 'INV-2026-003', nominal: 1200000 },
      { no: 4,  tanggal: '2026-06-26', inv_no: 'INV-2026-004', nominal: 620000  },
      { no: 5,  tanggal: '2026-06-27', inv_no: 'INV-2026-005', nominal: 3950000 },
      { no: 6,  tanggal: '2026-06-28', inv_no: 'INV-2026-006', nominal: 1080000 },
      { no: 7,  tanggal: '2026-06-29', inv_no: 'INV-2026-007', nominal: 1450000 },
      { no: 8,  tanggal: '2026-06-30', inv_no: 'INV-2026-008', nominal: 1160000 },
      { no: 9,  tanggal: '2026-07-01', inv_no: 'INV-2026-009', nominal: 1100000 },
      { no: 10, tanggal: '2026-07-02', inv_no: 'INV-2026-010', nominal: 680000  },
    ];

    const btnAksi = (cell) => {
      const row = cell.getRow().getData();
      return `<a href="../invoice/invoice.php?inv_no=${encodeURIComponent(row.inv_no)}" class="btn btn-sm btn-info me-1">
                <i class="bi bi-eye"></i> Detail
              </a>`;
    };

    let tabelPembayaran;

    function terapkanFilter() {
      const keyword  = document.getElementById('search-keyword').value.trim().toLowerCase();
      const dateFrom = document.getElementById('search-date-from').value;
      const dateTo   = document.getElementById('search-date-to').value;

      tabelPembayaran.setFilter((data) => {
        let cocok = true;

        if (keyword) {
          cocok = cocok && data.inv_no.toLowerCase().includes(keyword);
        }
        if (dateFrom) {
          cocok = cocok && data.tanggal >= dateFrom;
        }
        if (dateTo) {
          cocok = cocok && data.tanggal <= dateTo;
        }

        return cocok;
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      tabelPembayaran = new Tabulator('#users-table', {
        theme: 'bootstrap5',
        data: dataPembayaran,
        layout: 'fitColumns',
        pagination: true,
        paginationSize: 10,
        paginationSizeSelector: [10, 25, 50],
        columns: [
          { title: 'No',        field: 'no',      hozAlign: 'center', width: 90 },
          { title: 'Tanggal',   field: 'tanggal',  hozAlign: 'center', sorter: 'date', width: 120 },
          { title: 'No. Faktur',   field: 'inv_no',  headerHozAlign: 'center',   hozAlign: 'center' },
          {
            title: 'Nominal', field: 'nominal', headerHozAlign: 'right', hozAlign: 'right',
            formatter: (cell) => fmt(cell.getValue())
          },
          { title: 'Aksi', field: 'inv_no', formatter: btnAksi, headerSort: false, hozAlign: 'center', width: 140 },
        ],
      });

      // Client-side filtering otomatis saat input berubah
      document.getElementById('search-keyword').addEventListener('input', terapkanFilter);
      document.getElementById('search-date-from').addEventListener('change', terapkanFilter);
      document.getElementById('search-date-to').addEventListener('change', terapkanFilter);

      document.getElementById('btn-reset').addEventListener('click', () => {
        document.getElementById('search-keyword').value = '';
        document.getElementById('search-date-from').value = '';
        document.getElementById('search-date-to').value = '';
        tabelPembayaran.clearFilter();
      });
    });
  </script>
</body>
</html>