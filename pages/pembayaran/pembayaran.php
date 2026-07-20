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
            <h3 class="mb-0">Pembayaran</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
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
            <h3 class="card-title">Data Pembayaran</h3>
          </div>
          <div class="card-body">

            <!-- ── Form Pencarian ── -->
            <div class="row g-2 mb-3">
              <div class="col-12 col-md-3">
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
              <div class="col-md-3 d-flex align-items-end gap-2">
                  <button id="btn-search" type="button" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Cari
                  </button>
                  <button id="btn-reset" type="button" class="btn btn-sm btn-outline-secondary w-100" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
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

    <!-- Dropdown custom pembayaran -->
    <div id="custom-dropdown-bayar" class="dropdown-menu shadow" style="display:none; position:fixed; z-index:9999; min-width:160px;">
      <a class="dropdown-item" id="ddb-detail" href="#"><i class="bi bi-eye me-2"></i>Detail</a>
      <hr class="dropdown-divider">
      <a class="dropdown-item text-danger" id="ddb-hapus" href="#"><i class="bi bi-trash me-2"></i>Hapus</a>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="../../dist/js/adminlte.js"></script>
  <script src="../../assets/js/dummy-data.js"></script>

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

    // ── Data pembayaran sekarang diambil dari DummyDB, sinkron dengan
    // pembayaran yang dicatat lewat modal "Bayar Sekarang" di invoice.php ──
    const dataPembayaran = DummyDB.getPayments();

    const btnAksi = (cell) => {
      const no = cell.getValue();
      return `<button class="btn btn-sm btn-warning" onclick="toggleDropdownBayar(event, ${no})">
        Aksi <i class="bi bi-chevron-down ms-1"></i>
      </button>`;
    };

    let activePayRowId = null;

function toggleDropdownBayar(e, id) {
      e.stopPropagation();
      const dd = document.getElementById('custom-dropdown-bayar');
      const rect = e.currentTarget.getBoundingClientRect();

      // Tutup jika klik tombol yang sama
      if (activePayRowId === id && dd.style.display === 'block') {
        dd.style.display = 'none'; 
        activePayRowId = null; 
        return;
      }

      // PERBAIKAN 1: Cari baris secara spesifik menggunakan data 'no', karena tabel tidak memakai 'id'
      const baris = tabelPembayaran.getRows().find(r => r.getData().id === id);
      const row = baris.getData();

      // Update parameter link Detail
      document.getElementById('ddb-detail').href = `../invoice/invoice.php?inv_no=${encodeURIComponent(row.inv_no)}`;
      
      // Fungsi Hapus dengan konfirmasi nama faktur
      document.getElementById('ddb-hapus').onclick = (ev) => {
        ev.preventDefault();
        if (confirm(`Apakah Anda yakin ingin menghapus data pembayaran untuk ${row.inv_no}?`)) { 
          baris.delete(); 
          dd.style.display = 'none'; 
          activePayRowId = null; 
        }
      };

      // Tampilkan Dropdown
      dd.style.display = 'block';
      dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
      
      // PERBAIKAN 2: Geser posisi kiri (offset) agar tidak terpotong di tepi layar
      dd.style.left = (rect.left + window.scrollX - 80) + 'px';
      
      activePayRowId = id;
    }
    document.addEventListener('click', () => {
      const dd = document.getElementById('custom-dropdown-bayar');
      if (dd) dd.style.display = 'none';
      activePayRowId = null;
    });

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

        paginationCounter: function(pageSize, currentRow, currentPage, totalRows, totalPages) {
            // Mengambil total seluruh data asli (sebelum terkena filter/pencarian)
            const totalDataKeseluruhan = tabelPembayaran.getData().length;
            
            // Format output sesuai permintaanmu
            return `Menampilkan ${pageSize} Data dari ${totalRows} Data, Total Data adalah ${totalDataKeseluruhan}`;
        },

        columns: [
          { title: 'No.',        field: 'id',   headerHozAlign: 'right',    hozAlign: 'center', width: 90 },
          { title: 'Tanggal',   field: 'tanggal',  headerHozAlign: 'center', hozAlign: 'center', sorter: 'date', width: 120 },
          { title: 'No. Faktur',   field: 'inv_no',  headerHozAlign: 'center',   hozAlign: 'center' },
          {
            title: 'Nominal', field: 'nominal', headerHozAlign: 'right', hozAlign: 'right',
            formatter: (cell) => fmt(cell.getValue())
          },
          {
            title: 'Sisa Faktur', field: 'inv_no', headerHozAlign: 'right', hozAlign: 'right',
            headerSort: false,
            formatter: (cell) => {
              // Diambil langsung dari data faktur terkait (DummyDB) — selalu
              // menampilkan sisa tagihan TERKINI, bukan sisa saat pembayaran
              // ini dulu dibuat.
              const inv = DummyDB.getInvoiceByNo(cell.getValue());
              if (!inv) return '<span class="text-secondary">-</span>';
              const teks = fmt(inv.sisa);
              return inv.sisa > 0 ? `<span class="fw-semibold text-danger">${teks}</span>` : `<span class="text-success">${teks}</span>`;
            },
          },
          { title: 'Aksi', field: 'id', formatter: btnAksi, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 120 },
        ],
      });

      // Client-side filtering
      document.getElementById('btn-search').addEventListener('click', terapkanFilter);
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