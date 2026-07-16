<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Omset</title>
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
                <h3 class="mb-0">Laporan</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-type="harian">Harian</button></li>
                            <li class="nav-item"><button class="nav-link" data-type="mingguan">Mingguan</button></li>
                            <li class="nav-item"><button class="nav-link" data-type="bulanan">Bulanan</button></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div id="users-table"></div>
                    </div>
                </div>

                <!-- Best Seller Table -->
                <div class="card mt-4">
                    <div class="card-header"><h3 class="card-title">Top 10 Produk Terlaris</h3></div>
                    <div class="card-body"><div id="best-seller-table"></div></div>
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
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Data dengan field yang seragam ('label') agar mudah diproses
        const data = {
    harian: [
        { id: 1, label: '2026-06-20 (Sabtu)', transaksi: 5, omset: 4500000 },
        { id: 2, label: '2026-06-21 (Minggu)', transaksi: 3, omset: 2100000 },
        { id: 3, label: '2026-06-22 (Senin)', transaksi: 7, omset: 6800000 },
        { id: 4, label: '2026-06-23 (Selasa)', transaksi: 4, omset: 3250000 },
        { id: 5, label: '2026-06-24 (Rabu)', transaksi: 6, omset: 5100000 },
        { id: 6, label: '2026-06-25 (Kamis)', transaksi: 3, omset: 1800000 },
        { id: 7, label: '2026-06-26 (Jumat)', transaksi: 7, omset: 6450000 },
        { id: 8, label: '2026-06-27 (Sabtu)', transaksi: 5, omset: 4300000 },
        { id: 9, label: '2026-06-28 (Minggu)', transaksi: 8, omset: 7200000 },
        { id: 10, label: '2026-06-29 (Senin)', transaksi: 2, omset: 980000 },
        { id: 11, label: '2026-06-30 (Selasa)', transaksi: 0, omset: null }
    ],
    mingguan: [
        { id: 1, label: 'Minggu 1 (Apr)', transaksi: 25, omset: 22000000 },
        { id: 2, label: 'Minggu 2 (Apr)', transaksi: 22, omset: 19500000 },
        { id: 3, label: 'Minggu 3 (Apr)', transaksi: 28, omset: 25000000 },
        { id: 4, label: 'Minggu 4 (Apr)', transaksi: 24, omset: 21000000 },
        { id: 5, label: 'Minggu 1 (Mei)', transaksi: 26, omset: 23500000 },
        { id: 6, label: 'Minggu 2 (Mei)', transaksi: 30, omset: 28000000 },
        { id: 7, label: 'Minggu 3 (Mei)', transaksi: 22, omset: 19000000 },
        { id: 8, label: 'Minggu 4 (Mei)', transaksi: 32, omset: 31000000 },
        { id: 9, label: 'Minggu 3 (Jun)', transaksi: 20, omset: 18900000 },
        { id: 10, label: 'Minggu 4 (Jun)', transaksi: 29, omset: 29080000 }
    ],
    bulanan: [
        { id: 1, label: 'September 2025', transaksi: 90, omset: 45000000 },
        { id: 2, label: 'Oktober 2025', transaksi: 95, omset: 48000000 },
        { id: 3, label: 'November 2025', transaksi: 88, omset: 44000000 },
        { id: 4, label: 'Desember 2025', transaksi: 120, omset: 60000000 },
        { id: 5, label: 'Januari 2026', transaksi: 80, omset: 42000000 },
        { id: 6, label: 'Februari 2026', transaksi: 75, omset: 38500000 },
        { id: 7, label: 'Maret 2026', transaksi: 100, omset: 51000000 },
        { id: 8, label: 'April 2026', transaksi: 92, omset: 47300000 },
        { id: 9, label: 'Mei 2026', transaksi: 110, omset: 55800000 },
        { id: 10, label: 'Juni 2026', transaksi: 85, omset: 83680000 }
    ]
};

        // 2. Konfigurasi kolom dinamis
        const columnConfigs = {
            harian: [
                { title: 'Tanggal & Hari', field: 'label' },
                { title: 'Jumlah Transaksi', field: 'transaksi', headerHozAlign: 'center', hozAlign: 'center' },
                { title: 'Total Omset', field: 'omset', formatter: "money", headerHozAlign: 'right', hozAlign: 'right', formatterParams: { currency: "IDR", precision: 0 } }
            ],
            mingguan: [
                { title: 'Minggu Ke', field: 'label' },
                { title: 'Jumlah Transaksi', field: 'transaksi', headerHozAlign: 'center', hozAlign: 'center' },
                { title: 'Total Omset', field: 'omset', formatter: "money", headerHozAlign: 'right', hozAlign: 'right', formatterParams: { currency: "IDR", precision: 0 } }
            ],
            bulanan: [
                { title: 'Bulan', field: 'label' },
                { title: 'Jumlah Transaksi', field: 'transaksi', headerHozAlign: 'center',  hozAlign: 'center' },
                { title: 'Total Omset', field: 'omset', formatter: "money", headerHozAlign: 'right', hozAlign: 'right', formatterParams: { currency: "IDR", precision: 0 } }
            ]
        };

        // Inisialisasi Tabel Omset
        const table = new Tabulator('#users-table', {
            theme: "bootstrap5",
            data: data.harian,
            layout: 'fitColumns',
            columns: columnConfigs.harian
        });

        // Event Tab Click
        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const type = this.getAttribute('data-type'); // Pastikan tombol di HTML punya attribute data-type
                table.setColumns(columnConfigs[type]);
                table.setData(data[type]);
            });
        });

        // Inisialisasi Tabel Best Seller
        new Tabulator('#best-seller-table', {
            theme: "bootstrap5",
            data: [
              { rank: 1, nama: 'Metal Structure RX-93 v-Gundam', terjual: 42, omset: 630000000 },
    { rank: 2, nama: 'PG Unleashed RX-78-2 Gundam', terjual: 78, omset: 163800000 },
    { rank: 3, nama: 'MG 1/100 Sazabi Ver.Ka', terjual: 95, omset: 114000000 },
    { rank: 4, nama: 'HG 1/144 Gundam Aerial', terjual: 130, omset: 32500000 },
    { rank: 5, nama: 'MGEX 1/100 Strike Freedom', terjual: 61, omset: 85400000 },
    { rank: 6, nama: 'RG 1/144 Hi-Nu Gundam', terjual: 88, omset: 63360000 },
    { rank: 7, nama: 'MG 1/100 Zeta Ver.Ka', terjual: 55, omset: 53900000 },
    { rank: 8, nama: 'HGCE Rising Freedom', terjual: 110, omset: 39600000 },
    { rank: 9, nama: 'PG 1/60 Strike Freedom', terjual: 30, omset: 144000000 },
    { rank: 10, nama: 'MG 1/100 Barbatos', terjual: 70, omset: 47600000 }
            ],
            layout: 'fitColumns',
            columns: [
                { title: 'Peringkat', field: 'rank', width: 100 },
                { title: 'Nama Produk', field: 'nama' },
                { title: 'Terjual', field: 'terjual' },
                { title: 'Omset', field: 'omset', formatter: "money", formatterParams: { currency: "IDR", precision: 0 } }
            ]
        });
    });
</script>

<style>
    /* Menargetkan semua header tabel Tabulator di halaman ini */
    .tabulator-header {
        background-color: #2c3e50 !important; /* Warna biru tua keabu-abuan */
        color: #ffffff !important;
    }

    /* Menargetkan kolom header secara spesifik */
    .tabulator-header .tabulator-col {
        background-color: #2c3e50 !important;
        color: #ffffff !important;
        border-right: 1px solid #1a252f !important; /* Opsional: agar garis antar kolom terlihat */
    }

    /* Memastikan teks judul kolom putih saat di-hover */
    .tabulator-header .tabulator-col:hover {
        background-color: #34495e !important;
    }

    /* Jika ada ikon sort/arrow, buat warnanya putih agar terlihat */
    .tabulator-header .tabulator-col .tabulator-col-content .tabulator-arrow {
        border-top-color: #ffffff !important;
    }
</style>
  </body>
</html>