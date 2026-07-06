<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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
            <h3 class="mb-0">Beranda</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item active" aria-current="page">Beranda</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">

        <!-- Kartu Ringkasan -->
        <div class="row g-3 mb-4">
          <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width:48px;height:48px;flex-shrink:0">
                  <i class="bi bi-calendar-day text-primary fs-5"></i>
                </div>
                <div>
                  <p class="text-secondary small mb-0">Omset Harian</p>
                  <h5 class="mb-0 fw-semibold" id="val-harian">Rp 0</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:48px;height:48px;flex-shrink:0">
                  <i class="bi bi-calendar-week text-success fs-5"></i>
                </div>
                <div>
                  <p class="text-secondary small mb-0">Omset Mingguan</p>
                  <h5 class="mb-0 fw-semibold" id="val-mingguan">Rp 0</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10" style="width:48px;height:48px;flex-shrink:0">
                  <i class="bi bi-calendar-month text-warning fs-5"></i>
                </div>
                <div>
                  <p class="text-secondary small mb-0">Omset Bulanan</p>
                  <h5 class="mb-0 fw-semibold" id="val-bulanan">Rp 0</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10" style="width:48px;height:48px;flex-shrink:0">
                  <i class="bi bi-trophy text-danger fs-5"></i>
                </div>
                <div>
                  <p class="text-secondary small mb-0">Produk Terlaris</p>
                  <h5 class="mb-0 fw-semibold" id="val-terlaris">-</h5>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <!-- ── Grafik Omset Bulanan ── -->
          <div class="col-lg-8">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0">Omset Bulanan (2026)</h6>
              </div>
              <div class="card-body">
                <canvas id="chartOmset" height="120"></canvas>
              </div>
            </div>
          </div>

          <!-- ── Best Seller ── -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0">Best Seller</h6>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="list-bestseller"></ul>
              </div>
            </div>
          </div>
        </div>

        <!-- ── Tabel Omset Harian ── -->
        <div class="card mb-4">
          <div class="card-header">
            <h6 class="card-title mb-0">Detail Omset Harian</h6>
          </div>
          <div class="card-body">
            <div id="tabel-harian"></div>
          </div>
        </div>

        <!-- ── Tabel Omset Mingguan ── -->
        <div class="card mb-4">
          <div class="card-header">
            <h6 class="card-title mb-0">Detail Omset Mingguan</h6>
          </div>
          <div class="card-body">
            <div id="tabel-mingguan"></div>
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
  <script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  
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

  <script>
    const fmt = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

    // ── Data Dummy ──
    const dataHarian = [
      { tanggal: '2026-06-23', transaksi: 4, omset: 3250000 },
      { tanggal: '2026-06-24', transaksi: 6, omset: 5100000 },
      { tanggal: '2026-06-25', transaksi: 3, omset: 1800000 },
      { tanggal: '2026-06-26', transaksi: 7, omset: 6450000 },
      { tanggal: '2026-06-27', transaksi: 5, omset: 4300000 },
      { tanggal: '2026-06-28', transaksi: 8, omset: 7200000 },
      { tanggal: '2026-06-29', transaksi: 2, omset: 980000  },
    ];

    const dataMingguan = [
      { minggu: 'Minggu 1 (Jun)', transaksi: 18, omset: 14200000 },
      { minggu: 'Minggu 2 (Jun)', transaksi: 24, omset: 21500000 },
      { minggu: 'Minggu 3 (Jun)', transaksi: 20, omset: 18900000 },
      { minggu: 'Minggu 4 (Jun)', transaksi: 29, omset: 29080000 },
    ];

    const dataBulanan = [
      { bulan: 'Jan', omset: 42000000 },
      { bulan: 'Feb', omset: 38500000 },
      { bulan: 'Mar', omset: 51000000 },
      { bulan: 'Apr', omset: 47300000 },
      { bulan: 'Mei', omset: 55800000 },
      { bulan: 'Jun', omset: 83680000 },
    ];

    const dataBestSeller = [
      { rank: 1, nama: 'Metal Structure Kaitai Shouki RX-93 v-Gundam', terjual: 42, omset: 630000000 },
      { rank: 2, nama: 'PG 1/60 Unleashed RX-78-2 Gundam',            terjual: 78, omset: 163800000 },
      { rank: 3, nama: 'MG 1/100 Sazabi Ver.Ka',                       terjual: 95, omset: 114000000 },
      { rank: 4, nama: 'HG 1/144 Gundam Aerial',                       terjual: 130,omset: 32500000  },
      { rank: 5, nama: 'MGEX 1/100 Strike Freedom Gundam',             terjual: 61, omset: 85400000  },
    ];

    document.addEventListener('DOMContentLoaded', () => {
      // ── Kartu ringkasan ──
      const omsetHarian   = dataHarian[dataHarian.length - 1].omset;
      const omsetMingguan = dataMingguan.reduce((s, r) => s + r.omset, 0);
      const omsetBulanan  = dataBulanan[dataBulanan.length - 1].omset;

      document.getElementById('val-harian').textContent   = fmt(omsetHarian);
      document.getElementById('val-mingguan').textContent = fmt(omsetMingguan);
      document.getElementById('val-bulanan').textContent  = fmt(omsetBulanan);
      document.getElementById('val-terlaris').textContent = dataBestSeller[0].nama;

      // ── Grafik omset bulanan ──
      new Chart(document.getElementById('chartOmset'), {
        type: 'bar',
        data: {
          labels: dataBulanan.map(r => r.bulan),
          datasets: [{
            label: 'Omset',
            data: dataBulanan.map(r => r.omset),
            backgroundColor: 'rgba(111,163,208,0.6)',
            borderColor: '#4e8abf',
            borderWidth: 1,
            borderRadius: 4,
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: { ticks: { callback: (v) => 'Rp ' + (v/1000000).toFixed(0) + 'jt' } }
          }
        }
      });

      // ── Best seller list ──
      const ul = document.getElementById('list-bestseller');
      const badgeColors = ['danger','warning','primary','secondary','secondary'];
      dataBestSeller.forEach((item) => {
        ul.innerHTML += `
          <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
            <div class="d-flex align-items-center gap-2">
              <span class="badge text-bg-${badgeColors[item.rank-1]}" style="width:24px">${item.rank}</span>
              <span class="small">${item.nama}</span>
            </div>
            <span class="small text-secondary">${item.terjual} terjual</span>
          </li>`;
      });

      // ── Tabel omset harian ──
      new Tabulator('#tabel-harian', {
        theme: 'bootstrap5',
        data: dataHarian,
        layout: 'fitColumns',
        columns: [
          { title: 'Tanggal',    field: 'tanggal',    hozAlign: 'center' },
          { title: 'Transaksi',  field: 'transaksi',  hozAlign: 'center' },
          { title: 'Omset',      field: 'omset',      hozAlign: 'right',
            formatter: (cell) => fmt(cell.getValue()) },
        ],
      });

      // ── Tabel omset mingguan ──
      new Tabulator('#tabel-mingguan', {
        theme: 'bootstrap5',
        data: dataMingguan,
        layout: 'fitColumns',
        columns: [
          { title: 'Minggu',     field: 'minggu',     hozAlign: 'center' },
          { title: 'Transaksi',  field: 'transaksi',  hozAlign: 'center' },
          { title: 'Omset',      field: 'omset',      hozAlign: 'right',
            formatter: (cell) => fmt(cell.getValue()) },
        ],
      });
    });
  </script>
</body>
</html>