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
              <i class="bi bi-info-circle me-1"></i>Hanya menampilkan pelanggan yang masih memiliki sisa tagihan. Pelanggan yang sudah lunas otomatis tidak tercantum di sini.
            </p>

            <div id="users-table"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Dropdown custom: daftar faktur penyebab tunggakan pelanggan ini -->
  <div id="custom-dropdown-tunggakan" class="dropdown-menu shadow" style="display:none; position:fixed; z-index:9999; min-width:260px; max-width:320px;"></div>

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

    // ── Data tunggakan sekarang dihitung otomatis dari invoice + pembayaran
    // di DummyDB (bukan angka manual lagi) — begitu ada pembayaran baru,
    // angka "Total Terbayar" & "Sisa Tagihan" di sini otomatis ikut berubah ──
    // Halaman ini khusus menampilkan TUNGGAKAN, jadi pelanggan yang sisa
    // tagihannya sudah 0 (lunas) otomatis disaring keluar dari daftar.
    const dataTunggakan = DummyDB.getTunggakanPerPelanggan()
      .filter((r) => (r.total_inv - r.terbayar) > 0);

    // ── Custom formatter: hitung sisa tagihan secara dinamis ──
    const sisaTagihanFormatter = (cell) => {
      const data = cell.getRow().getData();
      const sisa = data.total_inv - data.terbayar;

      if (sisa > 0) {
        return `<span class="fw-bold text-danger">${fmt(sisa)}</span>`;
      }
      return `<span class="text-success">${fmt(sisa)}</span>`;
    };

    // ── Tombol Aksi: buka dropdown berisi rincian faktur penyebab tunggakan ──
    const btnAksiTunggakan = (cell) => {
      const nama = cell.getRow().getData().nama;
      return `<button class="btn btn-sm btn-outline-primary" onclick="toggleDropdownTunggakan(event, ${JSON.stringify(nama).replace(/"/g, '&quot;')})">
        Lihat Faktur <i class="bi bi-chevron-down ms-1"></i>
      </button>`;
    };

    let activeTunggakanName = null;

    function toggleDropdownTunggakan(e, nama) {
      e.stopPropagation();
      const dd = document.getElementById('custom-dropdown-tunggakan');
      const rect = e.currentTarget.getBoundingClientRect();

      if (activeTunggakanName === nama && dd.style.display === 'block') {
        dd.style.display = 'none';
        activeTunggakanName = null;
        return;
      }

      const row = dataTunggakan.find((r) => r.nama === nama);
      const faktur = row ? row.faktur : [];

      dd.innerHTML = faktur.length
        ? faktur.map((f) => {
            const badge = { paid: 'success', partial: 'info', unpaid: 'warning' }[f.status] || 'secondary';
            const label = { paid: 'Lunas', partial: 'Sebagian', unpaid: 'Belum Lunas' }[f.status] || f.status;
            return `
              <a class="dropdown-item d-flex justify-content-between align-items-center gap-2" href="../invoice/invoice.php?inv_no=${encodeURIComponent(f.inv_no)}">
                <span>
                  <span class="fw-semibold">${f.inv_no}</span>
                  <span class="badge text-bg-${badge} ms-1">${label}</span>
                </span>
                <span class="${f.sisa > 0 ? 'text-danger fw-semibold' : 'text-success'} small">${fmt(f.sisa)}</span>
              </a>`;
          }).join('<hr class="dropdown-divider my-1">')
        : '<span class="dropdown-item-text text-secondary small">Tidak ada faktur.</span>';

      dd.style.display = 'block';
      dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
      dd.style.left = (rect.left + window.scrollX - 120) + 'px';
      activeTunggakanName = nama;
    }

    document.addEventListener('click', () => {
      const dd = document.getElementById('custom-dropdown-tunggakan');
      if (dd) dd.style.display = 'none';
      activeTunggakanName = null;
    });

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
            title: 'Sisa Tagihan', field: 'sisa_tunggakan', hozAlign: 'right', headerHozAlign:'right',
            formatter: sisaTagihanFormatter,
          },
          { title: 'Aksi', field: 'aksi_tunggakan', formatter: btnAksiTunggakan, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 150 },
        ],
      });
    });

      function applySearch() {
        const nama = document.getElementById('search-nama').value.trim().toLowerCase();
        tabelTunggakan.setFilter((row) => !nama || row.nama.toLowerCase().includes(nama));
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