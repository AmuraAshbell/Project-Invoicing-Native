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

    <!-- ══════════════════════════════════════════════ -->
    <!-- HEADER HALAMAN -->
    <!-- ══════════════════════════════════════════════ -->
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

        <!-- BARIS 1 — KARTU KPI (4 Kolom) -->
        <div class="row g-4 mb-4">

          <!-- KPI 1: Pendapatan Bulan Ini -->
          <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:52px;height:52px;flex-shrink:0">
                  <i class="bi bi-cash-coin text-success fs-4"></i>
                </div>
                <div class="flex-grow-1">
                  <p class="text-secondary small mb-1">Pendapatan Bulan Ini</p>
                  <h4 class="mb-0 fw-bold" id="kpi-pendapatan">Rp 0</h4>
                  <span class="small text-success"><i class="bi bi-arrow-up-short"></i> <span id="kpi-pendapatan-growth">0%</span> dari bulan lalu</span>
                </div>
              </div>
            </div>
          </div>

          <!-- KPI 2: Total Piutang/Tunggakan -->
          <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10" style="width:52px;height:52px;flex-shrink:0">
                  <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                </div>
                <div class="flex-grow-1">
                  <p class="text-secondary small mb-1">Total Tunggakan</p>
                  <h4 class="mb-0 fw-bold" id="kpi-piutang">Rp 0</h4>
                  <span class="small text-danger"><i class="bi bi-clock-history"></i> <span id="kpi-piutang-count">0</span> faktur belum lunas</span>
                </div>
              </div>
            </div>
          </div>

          <!-- KPI 3: Total Faktur Terbit -->
          <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10" style="width:52px;height:52px;flex-shrink:0">
                  <i class="bi bi-receipt text-info fs-4"></i>
                </div>
                <div class="flex-grow-1">
                  <p class="text-secondary small mb-1">Total Faktur Terbit</p>
                  <h4 class="mb-0 fw-bold" id="kpi-faktur">0</h4>
                  <span class="small text-secondary">Bulan berjalan</span>
                </div>
              </div>
            </div>
          </div>

          <!-- KPI 4: Total Barang Aktif -->
          <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
              <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary bg-opacity-10" style="width:52px;height:52px;flex-shrink:0">
                  <i class="bi bi-box-seam text-secondary fs-4"></i>
                </div>
                <div class="flex-grow-1">
                  <p class="text-secondary small mb-1">Total Barang Aktif</p>
                  <h4 class="mb-0 fw-bold" id="kpi-barang">0</h4>
                  <span class="small text-secondary"><span id="kpi-barang-menipis">0</span> stok menipis</span>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- ══════════════════════════════════════════════ -->
        <!-- BARIS 2 — GRAFIK ARUS KAS & FAKTUR JATUH TEMPO -->
        <!-- ══════════════════════════════════════════════ -->
        <div class="row g-4 mb-4">

          <!-- Kiri: Grafik Arus Kas -->
          <div class="col-lg-8">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0"><i class="bi bi-graph-up-arrow me-1"></i>Grafik Pendapatan (6 Bulan Terakhir)</h6>
                <div class="d-flex align-items-center gap-3 small">
                  <span><span class="badge rounded-pill bg-success">&nbsp;</span> Pendapatan</span>
                  <span><span class="badge rounded-pill bg-danger">&nbsp;</span> Tunggakan</span>
                </div>
              </div>
              <div class="card-body">
                <canvas id="chartArusKas" height="110"></canvas>
              </div>
            </div>
          </div>

          <!-- Kanan: Faktur Jatuh Tempo -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-alarm me-1"></i>Faktur Jatuh Tempo</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead>
                      <tr class="text-secondary small">
                        <th>Pelanggan</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="tbody-jatuh-tempo">
                      <!-- diisi via JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer text-center bg-transparent">
                <a href="../tunggakan/tunggakan.php" class="small text-decoration-none">Lihat semua faktur jatuh tempo <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>

        </div>

        <!-- ══════════════════════════════════════════════ -->
        <!-- BARIS 3 — WAWASAN & OPERASIONAL (3 Kolom) -->
        <!-- ══════════════════════════════════════════════ -->
        <div class="row g-4 mb-4">

          <!-- Kiri: Peringatan Stok Menipis -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-exclamation-octagon text-danger me-1"></i>Peringatan Stok Menipis</h6>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="list-stok-menipis"></ul>
              </div>
            </div>
          </div>

          <!-- Tengah: Produk Terlaris -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-trophy text-warning me-1"></i>Produk Terlaris</h6>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="list-terlaris"></ul>
              </div>
            </div>
          </div>

          <!-- Kanan: Pelanggan Terbaik -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-star text-primary me-1"></i>Pelanggan Terbaik</h6>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="list-pelanggan-terbaik"></ul>
              </div>
            </div>
          </div>

        </div>

        <!-- ══════════════════════════════════════════════ -->
        <!-- BARIS 4 — RIWAYAT TRANSAKSI TERAKHIR (Full Width) -->
        <!-- ══════════════════════════════════════════════ -->
        <div class="row g-4 mb-4">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0"><i class="bi bi-clock-history me-1"></i>Riwayat Transaksi Terakhir</h6>
                <a href="../invoice/table-invoice.php" class="btn btn-sm btn-link text-decoration-none">Lihat semua <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr class="text-secondary small">
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Keterangan</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center">Status</th>
                      </tr>
                    </thead>
                    <tbody id="tbody-riwayat-transaksi">
                      <!-- diisi via JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
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

  <!-- ══════════════════════════════════════════════ -->
  <!-- SCRIPT: INISIALISASI DATA DUMMY & GRAFIK -->
  <!-- ══════════════════════════════════════════════ -->
  <script>
    const fmtRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

    // ── Data Dummy: KPI ──
    const kpi = {
      pendapatanBulanIni: 83680000,
      pendapatanGrowth: 12.4,
      totalPiutang: 24500000,
      jumlahFakturBelumLunas: 7,
      totalFakturTerbit: 58,
      totalBarangAktif: 214,
      barangMenipis: 6,
    };

    // ── Data Dummy: Arus Kas 6 Bulan ──
    const arusKas = {
      labels: ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
      pendapatan: [38500000, 51000000, 47300000, 55800000, 83680000, 61200000],
      tunggakan:  [9200000, 7400000, 11800000, 15300000, 24500000, 18700000],
    };

    // ── Data Dummy: Faktur Jatuh Tempo ──
    const fakturJatuhTempo = [
      { pelanggan: 'Toko Andalan Jaya',      nominal: 4500000 },
      { pelanggan: 'CV Mitra Sejahtera',      nominal: 7800000 },
      { pelanggan: 'Budi Santoso',            nominal: 1250000 },
      { pelanggan: 'PT Karya Abadi',          nominal: 9600000 },
      { pelanggan: 'Toko Sumber Rezeki',      nominal: 1350000 },
    ];

    // ── Data Dummy: Stok Menipis ──
    const stokMenipis = [
      { nama: 'HG 1/144 Gundam Aerial',            sisa: 3 },
      { nama: 'MG 1/100 Sazabi Ver.Ka',             sisa: 2 },
      { nama: 'RG 1/144 Nu Gundam',                 sisa: 4 },
      { nama: 'Cat Akrilik Mr. Hobby Set',          sisa: 5 },
      { nama: 'Nozzle Airbrush 0.3mm',              sisa: 1 },
    ];

    // ── Data Dummy: Produk Terlaris ──
    const produkTerlaris = [
      { nama: 'PG 1/60 Unleashed RX-78-2 Gundam',   terjual: 78 },
      { nama: 'MG 1/100 Sazabi Ver.Ka',             terjual: 95 },
      { nama: 'HG 1/144 Gundam Aerial',             terjual: 130 },
      { nama: 'MGEX 1/100 Strike Freedom Gundam',   terjual: 61 },
      { nama: 'Metal Structure RX-93 v-Gundam',     terjual: 42 },
    ];

    // ── Data Dummy: Pelanggan Terbaik ──
    const pelangganTerbaik = [
      { nama: 'PT Karya Abadi',        total: 45200000 },
      { nama: 'Toko Andalan Jaya',     total: 38900000 },
      { nama: 'CV Mitra Sejahtera',    total: 27650000 },
      { nama: 'Budi Santoso',          total: 15300000 },
      { nama: 'Toko Sumber Rezeki',    total: 12100000 },
    ];

    // ── Data Dummy: Riwayat Transaksi ──
    const riwayatTransaksi = [
      { no: 'INV-2026070045', tanggal: '09 Jul 2026', pelanggan: 'PT Karya Abadi',       ket: 'Pembelian Gunpla PG & MG', nominal: 9600000, status: 'Lunas' },
      { no: 'INV-2026070044', tanggal: '08 Jul 2026', pelanggan: 'Toko Andalan Jaya',    ket: 'Restok bulanan',           nominal: 4500000, status: 'Belum Lunas' },
      { no: 'INV-2026070043', tanggal: '08 Jul 2026', pelanggan: 'Budi Santoso',         ket: 'Pembelian eceran',         nominal: 1250000, status: 'Belum Lunas' },
      { no: 'INV-2026070042', tanggal: '07 Jul 2026', pelanggan: 'CV Mitra Sejahtera',   ket: 'Pembelian aksesoris',      nominal: 7800000, status: 'Jatuh Tempo' },
      { no: 'INV-2026070041', tanggal: '06 Jul 2026', pelanggan: 'Toko Sumber Rezeki',   ket: 'Pembelian cat & tools',    nominal: 1350000, status: 'Lunas' },
    ];

    document.addEventListener('DOMContentLoaded', () => {

      // ── Isi KPI ──
      document.getElementById('kpi-pendapatan').textContent = fmtRupiah(kpi.pendapatanBulanIni);
      document.getElementById('kpi-pendapatan-growth').textContent = kpi.pendapatanGrowth + '%';
      document.getElementById('kpi-piutang').textContent = fmtRupiah(kpi.totalPiutang);
      document.getElementById('kpi-piutang-count').textContent = kpi.jumlahFakturBelumLunas;
      document.getElementById('kpi-faktur').textContent = kpi.totalFakturTerbit;
      document.getElementById('kpi-barang').textContent = kpi.totalBarangAktif;
      document.getElementById('kpi-barang-menipis').textContent = kpi.barangMenipis;

      // ── Grafik Arus Kas ──
      new Chart(document.getElementById('chartArusKas'), {
        type: 'line',
        data: {
          labels: arusKas.labels,
          datasets: [
            {
              label: 'Pendapatan',
              data: arusKas.pendapatan,
              borderColor: '#28a745',
              backgroundColor: 'rgba(40,167,69,0.1)',
              tension: 0.35,
              fill: true,
              borderWidth: 2,
            },
            {
              label: 'Tunggakan',
              data: arusKas.tunggakan,
              borderColor: '#dc3545',
              backgroundColor: 'rgba(220,53,69,0.08)',
              tension: 0.35,
              fill: true,
              borderWidth: 2,
            }
          ]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: { ticks: { callback: (v) => 'Rp ' + (v / 1000000).toFixed(0) + 'jt' } }
          }
        }
      });

      // ── Tabel Faktur Jatuh Tempo ──
      const tbodyJT = document.getElementById('tbody-jatuh-tempo');
      fakturJatuhTempo.forEach((f) => {
        tbodyJT.innerHTML += `
          <tr>
            <td class="small">${f.pelanggan}</td>
            <td class="text-end small fw-semibold">${fmtRupiah(f.nominal)}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-send-fill"></i> Tagih
              </button>
            </td>
          </tr>`;
      });

      // ── List Stok Menipis ──
      const ulStok = document.getElementById('list-stok-menipis');
      stokMenipis.forEach((item) => {
        ulStok.innerHTML += `
          <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
            <span class="small">${item.nama}</span>
            <span class="badge text-bg-danger rounded-pill">${item.sisa} pcs</span>
          </li>`;
      });

      // ── List Produk Terlaris ──
      const ulTerlaris = document.getElementById('list-terlaris');
      const medalColors = ['warning', 'secondary', 'danger'];
      produkTerlaris
        .slice()
        .sort((a, b) => b.terjual - a.terjual)
        .forEach((item, idx) => {
          const badgeClass = idx < 3 ? medalColors[idx] : 'light text-dark';
          ulTerlaris.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
              <div class="d-flex align-items-center gap-2">
                <span class="badge text-bg-${badgeClass}" style="width:22px">${idx + 1}</span>
                <span class="small">${item.nama}</span>
              </div>
              <span class="small text-secondary">${item.terjual} terjual</span>
            </li>`;
        });

      // ── List Pelanggan Terbaik ──
      const ulPelanggan = document.getElementById('list-pelanggan-terbaik');
      pelangganTerbaik.forEach((item) => {
        ulPelanggan.innerHTML += `
          <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-person-circle text-primary"></i>
              <span class="small">${item.nama}</span>
            </div>
            <span class="small fw-semibold">${fmtRupiah(item.total)}</span>
          </li>`;
      });

      // ── Tabel Riwayat Transaksi ──
      const statusBadge = {
        'Lunas': 'success',
        'Belum Lunas': 'warning',
        'Jatuh Tempo': 'danger',
      };
      const tbodyRiwayat = document.getElementById('tbody-riwayat-transaksi');
      riwayatTransaksi.forEach((t) => {
        tbodyRiwayat.innerHTML += `
          <tr>
            <td class="small fw-semibold">${t.no}</td>
            <td class="small">${t.tanggal}</td>
            <td class="small">${t.pelanggan}</td>
            <td class="small text-secondary">${t.ket}</td>
            <td class="small text-end fw-semibold">${fmtRupiah(t.nominal)}</td>
            <td class="text-center"><span class="badge text-bg-${statusBadge[t.status]}">${t.status}</span></td>
          </tr>`;
      });

    });
  </script>
</body>
</html>