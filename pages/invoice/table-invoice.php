<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Table-Invoice</title>
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
              <h3 class="mb-0">Data Faktur</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="../../dashboard.php">Beranda</a></li>
                <li class="breadcrumb-item active">Tabel Faktur</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="app-content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Faktur</h3>
            </div>
            <div class="card-body">

            <div class="d-flex gap-2 my-2">
                  <a href="create-invoice.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                    Tambah Data
                  </a>
                  <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-csv me-1"></i>Export CSV
                  </button>
                  <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-json me-1"></i>Export JSON
                  </button>
                  <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1"></i>Print
                  </button>

                  <div class="vr mx-1"></div>

                  <button id="btn-test-success" type="button" class="btn btn-sm btn-success">
                    <i class="bi bi-check2-circle me-1"></i>Test Sukses
                  </button>
                  <button id="btn-test-error" type="button" class="btn btn-sm btn-danger">
                    <i class="bi bi-x-circle me-1"></i>Test Gagal
                  </button>
                </div>

            <div class="row g-2 my-3">
                <div class="col-md-3">
                  <label for="search-keyword" class="form-label form-label-sm mb-1">Kata Kunci</label>
                  <input type="text" id="search-keyword" class="form-control form-control-sm" placeholder="No faktur / pelanggan...">
                </div>
                <div class="col-md-3">
                  <label for="search-customer" class="form-label form-label-sm mb-1">Pelanggan</label>
                  <select id="search-customer" class="form-select form-select-sm">
                    <option value="">Semua Pelanggan</option>
                    <option value="Harga Amelia">Amelia Price</option>
                    <option value="Budi Santoso">Budi Santoso</option>
                    <option value="Citra Dewi">Citra Dewi</option>
                    <option value="Daniel Wijaya">Daniel Wijaya</option>
                    <option value="Eka Putri">Eka Putri</option>
                    <option value="Fahmi Malik">Fahmi Malik</option>
                    <option value="Gita Permata">Gita Permata</option>
                    <option value="Hendra Wijaya">Hendra Wijaya</option>
                    <option value="Indah Lestari">Indah Lestari</option>
                    <option value="Joko Anwar">Joko Anwar</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label for="search-date-from" class="form-label form-label-sm mb-1">Tgl Dari</label>
                  <input type="date" id="search-date-from" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                  <label for="search-date-to" class="form-label form-label-sm mb-1">Tgl Ke</label>
                  <input type="date" id="search-date-to" class="form-control form-control-sm">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                  <button id="btn-search" type="button" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Cari
                  </button>
                  <button id="btn-reset" type="button" class="btn btn-sm btn-outline-secondary w-100" title="Reset Pencarian">
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
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = { scrollbarTheme: 'os-theme-light', scrollbarAutoHide: 'leave', scrollbarClickScroll: true };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined && !isMobile) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, { scrollbars: { theme: Default.scrollbarTheme, autoHide: Default.scrollbarAutoHide, clickScroll: Default.scrollbarClickScroll } });
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
      const statusBadge = (cell) => {
        const val = cell.getValue();
        const map = { paid: ['Lunas','success'], unpaid: ['Belum Lunas','warning'], cancelled: ['Dibatalkan','secondary'] };
        const [label, color] = map[val] || [val, 'secondary'];
        return `<span class="badge text-bg-${color}">${label}</span>`;
      };

const btnAksi = (cell) => {
  const row = cell.getRow().getData();
  const paramsDetail = `id=${row.id}&inv_no=${encodeURIComponent(row.inv_no)}&customer=${encodeURIComponent(row.customer||'')}&due_date=${encodeURIComponent(row.due_date||'')}`;
  const paramsEdit   = `id=${row.id}&inv_no=${encodeURIComponent(row.inv_no)}`;
  return `<a href="invoice.php?${paramsDetail}" class="btn btn-sm btn-info me-1">
            <i class="bi bi-eye"></i> Detail
          </a>
          <a href="edit-invoice.php?${paramsEdit}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil-square"></i> Ubah
          </a>`;
};

      document.addEventListener('DOMContentLoaded', () => {
        const data = [
          { id:1,  inv_no:"INV-2026-001", customer:"Amelia Price",   due_date:"2026-07-01", price:650000,  status:"paid"      },
          { id:2,  inv_no:"INV-2026-002", customer:"Budi Santoso",   due_date:"2026-07-05", price:1560000, status:"unpaid"    },
          { id:3,  inv_no:"INV-2026-003", customer:"Citra Dewi",     due_date:"2026-07-10", price:1200000, status:"paid"      },
          { id:4,  inv_no:"INV-2026-004", customer:"Daniel Wijaya",  due_date:"2026-07-12", price:620000,  status:"cancelled" },
          { id:5,  inv_no:"INV-2026-005", customer:"Eka Putri",      due_date:"2026-07-15", price:3950000, status:"paid"      },
          { id:6,  inv_no:"INV-2026-006", customer:"Fahmi Malik",    due_date:"2026-07-18", price:1080000, status:"unpaid"    },
          { id:7,  inv_no:"INV-2026-007", customer:"Gita Permata",   due_date:"2026-07-20", price:1450000, status:"paid"      },
          { id:8,  inv_no:"INV-2026-008", customer:"Hendra Wijaya",  due_date:"2026-07-22", price:1160000, status:"unpaid"    },
          { id:9,  inv_no:"INV-2026-009", customer:"Indah Lestari",  due_date:"2026-07-25", price:1100000, status:"paid"      },
          { id:10, inv_no:"INV-2026-010", customer:"Joko Anwar",     due_date:"2026-07-28", price:680000,  status:"cancelled" },
        ];

        const table = new Tabulator('#users-table', {
          theme: "bootstrap5",
          data: data,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50, 100],
          movableColumns: true,
          columns: [
            { title: 'ID',             field: 'id',       hozAlign: 'center', headerSort: true, width: 70 },
            { title: 'Nomor Faktur',   field: 'inv_no',   hozAlign: 'center', headerSort: true },
            { title: 'Nama Pelanggan', field: 'customer', headerSort: false },
            { title: 'Jatuh Tempo',    field: 'due_date', headerSort: true },
            {
              title: 'Total Harga', field: 'price', headerSort: true, hozAlign: 'right',
              formatter: (cell) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(cell.getValue()),
            },
            { title: 'Status', field: 'status', formatter: statusBadge, headerSort: false, hozAlign: 'center', width: 130 },
            // { title: 'Detail', field: 'id',     formatter: btnDetail,   headerSort: false, hozAlign: 'center', width: 110 },
            { title: 'Aksi',   field: 'id',     formatter: btnAksi,     headerSort: false, hozAlign: 'center', width: 200 },
          ],
        });

                // Fungsi Logika Pencarian Lanjutan
        function applySearch() {
          const keyword  = document.getElementById('search-keyword').value.trim();
          const customer = document.getElementById('search-customer').value;
          const dateFrom = document.getElementById('search-date-from').value;
          const dateTo   = document.getElementById('search-date-to').value;

          const filters = [];

          // Filter Kata Kunci (Nomor Faktur ATAU Nama Pelanggan)
          if (keyword) {
            filters.push([
              { field: 'inv_no',   type: 'like', value: keyword },
              { field: 'customer', type: 'like', value: keyword },
            ]);
          }
          // Filter Spesifik Customer
          if (customer) {
            filters.push({ field: 'customer', type: '=', value: customer });
          }
          // Filter Rentang Tanggal Jatuh Tempo
          if (dateFrom) {
            filters.push({ field: 'due_date', type: '>=', value: dateFrom });
          }
          if (dateTo) {
            filters.push({ field: 'due_date', type: '<=', value: dateTo });
          }

          // Terapkan ke tabel Tabulator
          if (filters.length > 0) {
            table.setFilter(filters);
          } else {
            table.clearFilter();
          }
        }

        // Jalankan pencarian saat tombol "Cari" diklik
        document.getElementById('btn-search').addEventListener('click', applySearch);

        // Fungsi untuk mereset semua filter ke kondisi awal
        document.getElementById('btn-reset').addEventListener('click', () => {
          document.getElementById('search-keyword').value  = '';
          document.getElementById('search-customer').value = '';
          document.getElementById('search-date-from').value = '';
          document.getElementById('search-date-to').value   = '';
          table.clearFilter();
        });


        // document.getElementById('table-filter').addEventListener('input', (e) => {
        //   const v = e.target.value;
        //   if (v) { table.setFilter([[{ field: 'inv_no', type: 'like', value: v }, { field: 'customer', type: 'like', value: v }]]); } else { table.clearFilter(); }
        // });

        document.getElementById('export-csv').addEventListener('click',   () => table.download('csv',  'faktur.csv'));
        document.getElementById('export-json').addEventListener('click',  () => table.download('json', 'faktur.json'));
        document.getElementById('print-table').addEventListener('click',  () => table.print(false, true));
      });
    </script>

  <script>
          // Menampilkan notifikasi sukses
      document.getElementById('btn-test-success').addEventListener('click', () => {
        const toastSukses = new bootstrap.Toast(document.getElementById('toast-success'), {
          delay: 3000 // Menghilang otomatis setelah 3 detik
        });
        toastSukses.show();
      });

      // Menampilkan notifikasi gagal
      document.getElementById('btn-test-error').addEventListener('click', () => {
        const toastGagal = new bootstrap.Toast(document.getElementById('toast-error'), {
          delay: 4000 // Menghilang otomatis setelah 4 detik
        });
        toastGagal.show();
      });
  </script>

  <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1055;">
  
  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body fw-medium">
        <i class="bi bi-check-circle-fill me-2"></i> Aksi berhasil! Data telah disimpan.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
    </div>
  </div>

  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body fw-medium">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Terjadi kesalahan. Gagal menyimpan data!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
    </div>
  </div>

</div>
  </body>
</html>