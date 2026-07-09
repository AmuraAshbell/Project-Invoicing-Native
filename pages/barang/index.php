<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Table-Data</title>
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
                <h3 class="mb-0">Tabel Barang</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tabel Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>  
        <div class="app-content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Barang</h3>

              </div>
              <div class="card-body">
                <div class="d-flex gap-2 mb-3">
                  <a href="create.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                    Tambah Data
                  </a>
                  <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                    Export CSV
                  </button>
                  <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                    Export JSON
                  </button>
                  <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                    Print
                  </button>
                </div>

                <!-- Search -->
                <div class="row g-2 mb-3">
                  <div class="col-10 col-md-3">
                    <label for="search-nama" class="form-label form-label-sm mb-1">Nama Barang</label>
                    <input type="text" id="search-nama" class="form-control form-control-sm" placeholder="Cari nama barang...">
                  </div>
                  <div class="col-10 col-md-2">
                    <label for="search-refno" class="form-label form-label-sm mb-1">Nomor Referensi</label>
                    <input type="text" id="search-refno" class="form-control form-control-sm" placeholder="Cari ref no...">
                  </div>
                  <div class="col-6 col-md-2">
                    <label for="search-harga-min" class="form-label form-label-sm mb-1">Harga Min</label>
                    <input type="number" id="search-harga-min" class="form-control form-control-sm" placeholder="0">
                  </div>
                  <div class="col-6 col-md-2">
                    <label for="search-harga-max" class="form-label form-label-sm mb-1">Harga Max</label>
                    <input type="number" id="search-harga-max" class="form-control form-control-sm" placeholder="9999999">
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

                <div id="users-table"></div>
              </div>
            </div>
          </div>
        </div>
      </main>
        <?php include "../../layout/footer.php"; ?>

            <!-- Dropdown custom -->
    <div id="custom-dropdown" class="dropdown-menu shadow" style="display:none; position:fixed; z-index:9999; min-width:160px;">
      <a class="dropdown-item" id="dd-ubah" href="#"><i class="bi bi-pencil-square me-2"></i>Ubah</a>
      <hr class="dropdown-divider">
      <a class="dropdown-item text-danger" id="dd-hapus" href="#"><i class="bi bi-trash me-2"></i>Hapus</a>
    </div>

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
      const statusBadge = (cell) => {
        const value = cell.getValue();
        const map = { Active: 'success', Invited: 'info', Suspended: 'secondary' };
        const color = map[value] || 'secondary';
        return `<span class="badge text-bg-${color}">${value}</span>`;
      };

      // Tombol Aksi — hanya render button, data diambil saat klik
      const btnAksi = (cell) => {
        const id = cell.getValue();
        return `<button class="btn btn-sm btn-warning" onclick="toggleDropdown(event, ${id})">
          Aksi <i class="bi bi-chevron-down ms-1"></i>
        </button>`;
      };

      let table;
      let activeRowId = null;

      function toggleDropdown(e, id) {
        e.stopPropagation();
        const dd = document.getElementById('custom-dropdown');
        const rect = e.currentTarget.getBoundingClientRect();

        // Tutup jika klik tombol yang sama
        if (activeRowId === id && dd.style.display === 'block') {
          dd.style.display = 'none';
          activeRowId = null;
          return;
        }

        // Ambil data baris yang diklik
        const row = table.getRow(id).getData();

        // Sesuaikan parameter URL untuk form Edit Barang (karena ini tabel barang, bukan invoice)
        document.getElementById('dd-ubah').href = `edit.php?id=${row.id}&ref_no=${encodeURIComponent(row.ref_no)}`;

        // Fungsi ketika tombol hapus di dalam dropdown diklik
        document.getElementById('dd-hapus').onclick = (ev) => {
          ev.preventDefault();
          if (confirm(`Apakah Anda yakin ingin menghapus barang "${row.name}"?`)) {
            table.getRow(id).delete();
            dd.style.display = 'none';
            activeRowId = null;
          }
        };

        // Posisi dropdown di bawah tombol
        dd.style.display = 'block';
        dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
        
        // Agar dropdown tidak keluar layar/terpotong di ujung kanan
        dd.style.left = (rect.left + window.scrollX - 80) + 'px';
        activeRowId = id;
      }

      // Klik di luar → tutup dropdown
      document.addEventListener('click', () => {
        const dd = document.getElementById('custom-dropdown');
        if (dd) dd.style.display = 'none';
        activeRowId = null;
      });

      document.addEventListener('DOMContentLoaded', () => {
        const data = [
  {
    id: 1,
    ref_no: "GDM-001",
    name: "RG 1/144 RX-93 v Gundam (Nu Gundam)",
    price: 650000
  },
  {
    id: 2,
    ref_no: "GDM-002",
    name: "MG 1/100 Eclipse Gundam",
    price: 780000
  },
  {
    id: 3,
    ref_no: "GDM-003",
    name: "HG 1/144 Gundam Aerial (The Witch from Mercury)",
    price: 240000
  },
  {
    id: 4,
    ref_no: "GDM-004",
    name: "MGSD Freedom Gundam",
    price: 620000
  },
  {
    id: 5,
    ref_no: "GDM-005",
    name: "PG Unchained 1/60 RX-78-2 Gundam Unleashed",
    price: 3950000
  },
  {
    id: 6,
    ref_no: "GDM-006",
    name: "HGCE 1/144 Rising Freedom Gundam",
    price: 360000
  },
  {
    id: 7,
    ref_no: "GDM-007",
    name: "MG 1/100 MSN-04 Sazabi Ver.Ka",
    price: 1450000
  },
  {
    id: 8,
    ref_no: "GDM-008",
    name: "RG 1/144 God Gundam",
    price: 580000
  },
  {
    id: 9,
    ref_no: "GDM-009",
    name: "EG 1/144 RX-78-2 Gundam",
    price: 110000
  },
  {
    id: 10,
    ref_no: "GDM-010",
    name: "MG 1/100 Gundam Barbatos",
    price: 680000
  },
  {
    id: 11,
    ref_no: "GDM-011",
    name: "HGUC 1/144 RX-0 Unicorn Gundam (Destroy Mode)",
    price: 280000
  },
  {
    id: 12,
    ref_no: "GDM-012",
    name: "RG 1/144 MSN-04 Sazabi",
    price: 690000
  },
  {
    id: 13,
    ref_no: "GDM-013",
    name: "MG 1/100 Dynames Gundam",
    price: 650000
  },
  {
    id: 14,
    ref_no: "GDM-014",
    name: "HG 1/144 Gundam Calibarn",
    price: 290000
  },
  {
    id: 15,
    ref_no: "GDM-015",
    name: "PG 1/60 Strike Freedom Gundam",
    price: 3500000
  },
  {
    id: 16,
    ref_no: "GDM-016",
    name: "RG 1/144 Hi-v Gundam (Hi-Nu)",
    price: 720000
  },
  {
    id: 17,
    ref_no: "GDM-017",
    name: "MG 1/100 GAT-X105A Aile Strike Gundam Ver.RM",
    price: 600000
  },
  {
    id: 18,
    ref_no: "GDM-018",
    name: "HGAC 1/144 Wing Gundam Zero",
    price: 260000
  },
  {
    id: 19,
    ref_no: "GDM-019",
    name: "MGSD Barbatos",
    price: 640000
  },
  {
    id: 20,
    ref_no: "GDM-020",
    name: "EG 1/144 Strike Gundam",
    price: 115000
  },
  {
    id: 21,
    ref_no: "GDM-021",
    name: "RG 1/144 Wing Gundam Zero Custom EW",
    price: 420000
  },
  {
    id: 22,
    ref_no: "GDM-022",
    name: "MG 1/100 Gundam Kyrios",
    price: 750000
  },
  {
    id: 23,
    ref_no: "GDM-023",
    name: "HG 1/144 Gundam Lfrith",
    price: 250000
  },
  {
    id: 24,
    ref_no: "GDM-024",
    name: "MG 1/100 GN-001 Gundam Exia",
    price: 580000
  },
  {
    id: 25,
    ref_no: "GDM-025",
    name: "PG 1/60 Gundam Exia (Lighting Model)",
    price: 4800000
  },
  {
    id: 26,
    ref_no: "GDM-026",
    name: "RG 1/144 GN-0000+GNR-010 00 Raiser",
    price: 480000
  },
  {
    id: 27,
    ref_no: "GDM-027",
    name: "HGCE 1/144 Immortal Justice Gundam",
    price: 350000
  },
  {
    id: 28,
    ref_no: "GDM-028",
    name: "MG 1/100 Providence Gundam",
    price: 790000
  },
  {
    id: 29,
    ref_no: "GDM-029",
    name: "RG 1/144 RX-78-2 Gundam Ver.2.0",
    price: 540000
  },
  {
    id: 30,
    ref_no: "GDM-030",
    name: "MG 1/100 Zeta Gundam Ver.Ka",
    price: 980000
  }
];

          table = new Tabulator('#users-table', {
          theme: "bootstrap5",
          data: data,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50, 100],
          movableColumns: true,

          paginationCounter: function(pageSize, currentRow, currentPage, totalRows, totalPages) {
            // Mengambil total seluruh data asli (sebelum terkena filter/pencarian)
            const totalDataKeseluruhan = table.getData().length;
            
            // Format output sesuai permintaanmu
            return `Menampilkan ${pageSize} Data dari ${totalRows} Data, Total Data adalah ${totalDataKeseluruhan}`;
        },

          columns: [
            { title: 'No.',     field: 'id', headerHozAlign: 'center', hozAlign: 'center',    headerSort: true, width: 80 },
            { title: 'Nomor Referensi', field: 'ref_no', headerHozAlign: 'center', hozAlign: 'center', headerSort: true },
            { title: 'Nama Barang',   field: 'name',   headerSort: false },
            {
              title: 'Harga', field: 'price', headerSort: true, headerHozAlign: 'right', hozAlign: 'right',
              formatter: (cell) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(cell.getValue()),
            },
            { title: 'Aksi', field: 'id', formatter: btnAksi, headerHozAlign: 'center', headerSort: false, hozAlign: 'center', width: 100 },
          ],
        });

        function applySearch() {
          const nama    = document.getElementById('search-nama').value.trim();
          const refno   = document.getElementById('search-refno').value.trim();
          const hargaMin = parseInt(document.getElementById('search-harga-min').value) || 0;
          const hargaMax = parseInt(document.getElementById('search-harga-max').value) || 99999999;
          const filters = [];
          if (nama)  filters.push({ field: 'name',   type: 'like', value: nama });
          if (refno) filters.push({ field: 'ref_no', type: 'like', value: refno });
          filters.push({ field: 'price', type: '>=', value: hargaMin });
          filters.push({ field: 'price', type: '<=', value: hargaMax });
          table.setFilter(filters);
        }
        document.getElementById('btn-search').addEventListener('click', applySearch);
        document.getElementById('search-nama').addEventListener('input', applySearch);
        document.getElementById('search-refno').addEventListener('input', applySearch);
        document.getElementById('btn-reset').addEventListener('click', () => {
          document.getElementById('search-nama').value      = '';
          document.getElementById('search-refno').value     = '';
          document.getElementById('search-harga-min').value = '';
          document.getElementById('search-harga-max').value = '';
          table.clearFilter();
        });

        document.getElementById('export-csv').addEventListener('click', () => table.download('csv', 'users.csv'));
        document.getElementById('export-json').addEventListener('click', () => table.download('json', 'users.json'));
        document.getElementById('print-table').addEventListener('click', () => table.print(false, true));
      });
    </script>

    <script>
  (function () {
    const page = location.pathname.split('/').pop().replace(/\.[^.]+$/, '') || 'dashboard';
    const barangPages   = ['index', 'edit', 'create'];
    const customerPages = ['customer', 'edit-customer', 'create-customer'];

    document.querySelectorAll('[data-page]').forEach(li => {
      if (li.dataset.page === page) {
        li.querySelector('.nav-link').classList.add('active');
      }
    });

    function openGroup(pages, groupName) {
      if (pages.includes(page)) {
        const group = document.querySelector(`[data-group="${groupName}"]`);
        if (group) {
          group.classList.add('menu-open');
          group.querySelector(':scope > .nav-link').classList.add('active');
        }
      }
    }

    openGroup(barangPages,   'barang');
    openGroup(customerPages, 'customer');
  })();
</script>
  </body>
</html>