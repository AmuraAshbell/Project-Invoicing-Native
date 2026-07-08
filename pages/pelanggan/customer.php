<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Table-Pelanggan</title>
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
                <h3 class="mb-0">Tabel Pelanggan</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="../../dashboard.php">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tabel Pelanggan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pelanggan</h3>

              </div>
              <div class="card-body">
                <div class="d-flex gap-2 mb-3">
                  <a href="create-customer.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                    Tambah Pelanggan
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
                  <div class="col-12 col-md-3">
                    <label for="search-nama" class="form-label form-label-sm mb-1">Nama Pelanggan</label>
                    <input type="text" id="search-nama" class="form-control form-control-sm" placeholder="Cari nama pelanggan...">
                  </div>
                  <div class="col-12 col-md-3">
                    <label for="search-telepon" class="form-label form-label-sm mb-1">Nomor Telepon</label>
                    <input type="text" id="search-telepon" class="form-control form-control-sm" placeholder="Cari nomor telepon...">
                  </div>
                  <div class="col-12 col-md-3">
                    <label for="search-alamat" class="form-label form-label-sm mb-1">Alamat</label>
                    <input type="text" id="search-alamat" class="form-control form-control-sm" placeholder="Cari alamat...">
                  </div>
                  <div class="col-10 col-md-3 d-flex align-items-end gap-2">
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
        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
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
        const getPreferredTheme = () => {
          const stored = getStoredTheme();
          if (stored) return stored;
          return prefersDark() ? 'dark' : 'light';
        };
        const setTheme = (theme) => {
          const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
          document.documentElement.setAttribute('data-bs-theme', resolved);
        };
        setTheme(getPreferredTheme());
        const showActiveTheme = (theme) => {
          document.querySelectorAll('[data-bs-theme-value]').forEach((el) => {
            el.classList.remove('active');
            el.setAttribute('aria-pressed', 'false');
            const check = el.querySelector('.bi-check-lg');
            if (check) check.classList.add('d-none');
          });
          const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
          if (active) {
            active.classList.add('active');
            active.setAttribute('aria-pressed', 'true');
            const check = active.querySelector('.bi-check-lg');
            if (check) check.classList.remove('d-none');
          }
          document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
            icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme);
          });
        };
        globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
          const stored = getStoredTheme();
          if (!stored || stored === 'auto') setTheme(getPreferredTheme());
        });
        document.addEventListener('DOMContentLoaded', () => {
          showActiveTheme(getPreferredTheme());
          document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
            toggle.addEventListener('click', () => {
              const theme = toggle.getAttribute('data-bs-theme-value');
              setStoredTheme(theme);
              setTheme(theme);
              showActiveTheme(theme);
            });
          });
        });
      })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
    <script>
      const actionButtons = (cell) => {
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
        if (activeRowId === id && dd.style.display === 'block') {
          dd.style.display = 'none'; activeRowId = null; return;
        }
        const row = table.getRow(id).getData();
        const params = `id=${row.id}&ref_no=${encodeURIComponent(row.ref_no)}&name=${encodeURIComponent(row.name)}&address=${encodeURIComponent(row.address)}&phone=${encodeURIComponent(row.phone)}`;
        document.getElementById('dd-ubah').href = `edit-customer.php?${params}`;
        document.getElementById('dd-hapus').onclick = (ev) => {
          ev.preventDefault();
          if (confirm('Hapus pelanggan ini?')) { table.getRow(id).delete(); dd.style.display = 'none'; activeRowId = null; }
        };
        dd.style.display = 'block';
        dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
        dd.style.left = (rect.left + window.scrollX) + 'px';
        activeRowId = id;
      }

      document.addEventListener('click', () => {
        const dd = document.getElementById('custom-dropdown');
        if (dd) dd.style.display = 'none';
        activeRowId = null;
      });

      document.addEventListener('DOMContentLoaded', () => {
        const data = [
          { id: 1, ref_no: "REF-001", name: "Amelia Price",    address: "Jl. Merdeka No. 12, Jakarta",         phone: "0812-3456-7890" },
          { id: 2, ref_no: "REF-002", name: "Budi Santoso",    address: "Jl. Dago No. 45, Bandung",            phone: "0813-9876-5432" },
          { id: 3, ref_no: "REF-003", name: "Citra Dewi",      address: "Jl. Malioboro No. 88, Yogyakarta",    phone: "0856-4321-8765" },
          { id: 4, ref_no: "REF-004", name: "Daniel Wijaya",   address: "Jl. Basuki Rahmat No. 101, Surabaya", phone: "0811-2233-4455" },
          { id: 5, ref_no: "REF-005", name: "Eka Putri",       address: "Jl. Gajah Mada No. 23, Semarang",    phone: "0878-5566-7788" },
          { id: 6, ref_no: "REF-006", name: "Fahmi Malik",     address: "Jl. Sudirman No. 56, Medan",          phone: "0821-9988-7766" },
          { id: 7, ref_no: "REF-007", name: "Gita Permata",    address: "Jl. Pettarani No. 14, Makassar",      phone: "0819-1122-3344" },
          { id: 8, ref_no: "REF-008", name: "Hendra Wijaya",   address: "Jl. Teuku Umar No. 9, Denpasar",      phone: "0852-7788-9900" },
          { id: 9, ref_no: "REF-009", name: "Indah Lestari",   address: "Jl. Ahmad Yani No. 72, Banjarmasin",  phone: "0813-4455-6677" },
          { id: 10, ref_no: "REF-010", name: "Joko Anwar",     address: "Jl. Pemuda No. 5, Palembang",         phone: "0888-1234-5678" },
        ];

        table = new Tabulator('#users-table', {
          theme: "bootstrap5",
          data: data,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50, 100],
          movableColumns: true,
          columns: [
            { title: 'ID',      field: 'id', headerHozAlign: 'center',  hozAlign: 'center',    headerSort: true, width: 80 },
            { title: 'Nomor Referensi',  field: 'ref_no', headerHozAlign: 'center', hozAlign: 'center', headerSort: true },
            { title: 'Nama Pelanggan',    field: 'name',    headerSort: false },
            { title: 'Alamat', field: 'address', headerSort: false },
            { title: 'Nomor Telepon',   field: 'phone', headerSort: false },
            { title: 'Aksi',  field: 'id',      formatter: actionButtons, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 120 },
          ],
        });

        function applySearch() {
          const nama    = document.getElementById('search-nama').value.trim();
          const telepon = document.getElementById('search-telepon').value.trim();
          const alamat  = document.getElementById('search-alamat').value.trim();
          const filters = [];
          if (nama)    filters.push({ field: 'name',    type: 'like', value: nama });
          if (telepon) filters.push({ field: 'phone',   type: 'like', value: telepon });
          if (alamat)  filters.push({ field: 'address', type: 'like', value: alamat });
          filters.length > 0 ? table.setFilter(filters) : table.clearFilter();
        }
        document.getElementById('btn-search').addEventListener('click', applySearch);
        document.getElementById('search-nama').addEventListener('input', applySearch);
        document.getElementById('search-telepon').addEventListener('input', applySearch);
        document.getElementById('search-alamat').addEventListener('input', applySearch);
        document.getElementById('btn-reset').addEventListener('click', () => {
          document.getElementById('search-nama').value    = '';
          document.getElementById('search-telepon').value = '';
          document.getElementById('search-alamat').value  = '';
          table.clearFilter();
        });

        document.getElementById('export-csv').addEventListener('click', () => table.download('csv', 'users.csv'));
        document.getElementById('export-json').addEventListener('click', () => table.download('json', 'users.json'));
        document.getElementById('print-table').addEventListener('click', () => table.print(false, true));
      });
    </script>
  </body>
</html>