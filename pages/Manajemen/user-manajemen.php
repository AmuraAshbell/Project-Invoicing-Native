<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen PIC</title>
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
                    <div class="col-sm-6"><h3 class="mb-0">Tabel Pengguna</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
                            <li class="breadcrumb-item active">Tabel Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Kontak Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 mb-3">
                            <a href="create-user.php" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                                Tambah Data
                            </a>
                            <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-csv me-1"></i>Export CSV
                            </button>
                            <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-json me-1"></i>Export JSON
                            </button>
                        </div>
                        
                        <div class="row g-2 mb-3">
                          <div class="col-12 col-md-3">
                            <label for="search-nama" class="form-label form-label-sm mb-1">Nama Lengkap</label>
                            <input type="text" id="search-nama" class="form-control form-control-sm" placeholder="Cari nama...">
                          </div>
                          <div class="col-12 col-md-2">
                            <label for="search-status" class="form-label form-label-sm mb-1">Status</label>
                            <select id="search-status" class="form-select form-select-sm">
                              <option value="">Semua</option>
                              <option value="aktif">Aktif</option>
                              <option value="nonaktif">Tidak Aktif</option>
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

    <div id="custom-dropdown-pic" class="dropdown-menu shadow" style="display:none; position:fixed; z-index:9999; min-width:160px;">
      <a class="dropdown-item" id="dd-ubah" href="#"><i class="bi bi-pencil-square me-2"></i>Ubah</a>
      <hr class="dropdown-divider">
      <a class="dropdown-item text-danger" id="ddp-hapus" href="#"><i class="bi bi-trash me-2"></i>Hapus</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
    
    <script>
      // SCRIPT THEME (Bawaan Anda)
      (() => {
        'use strict';
        const STORAGE_KEY = 'lte-theme';
        const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
        const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
        const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
        const getPreferredTheme = () => { const s = getStoredTheme(); if (s) return s; return prefersDark() ? 'dark' : 'dark'; };
        const setTheme = (theme) => { const r = theme === 'auto' ? (prefersDark() ? 'dark' : 'dark') : theme; document.documentElement.setAttribute('data-bs-theme', r); };
        setTheme(getPreferredTheme());
        const showActiveTheme = (theme) => {
          document.querySelectorAll('[data-bs-theme-value]').forEach((el) => { el.classList.remove('active'); el.setAttribute('aria-pressed', 'false'); const c = el.querySelector('.bi-check-lg'); if (c) c.classList.add('d-none'); });
          const a = document.querySelector(`[data-bs-theme-value="${theme}"]`);
          if (a) { a.classList.add('active'); a.setAttribute('aria-pressed', 'true'); const c = a.querySelector('.bi-check-lg'); if (c) c.classList.remove('d-none'); }
          document.querySelectorAll('[data-lte-theme-icon]').forEach((i) => { i.classList.toggle('d-none', i.dataset.lteThemeIcon !== theme); });
        };
        globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => { const s = getStoredTheme(); if (!s || s === 'auto') setTheme(getPreferredTheme()); });
        document.addEventListener('DOMContentLoaded', () => {
          showActiveTheme(getPreferredTheme());
          document.querySelectorAll('[data-bs-theme-value]').forEach((t) => { t.addEventListener('click', () => { const th = t.getAttribute('data-bs-theme-value'); setStoredTheme(th); setTheme(th); showActiveTheme(th); }); });
        });
      })();
    </script>

    <script>
      // ── LOGIKA TABULATOR DAN CRUD PIC ──
      const PIC_KEY = 'app_pics';

      const defaultPICs = [
        { id: 1, nama: 'Budi Santoso', no_telp: '081234567890', email: 'budi@ptmaju.com', jabatan: 'Purchasing Manager', status: 'aktif' },
        { id: 2, nama: 'Siti Aminah', no_telp: '081987654321', email: 'siti@vendor.co.id', jabatan: 'Sales Representative', status: 'aktif' },
      ];

      function loadPICs() {
        const stored = localStorage.getItem(PIC_KEY);
        return stored ? JSON.parse(stored) : defaultPICs;
      }

      function savePICs(data) {
        localStorage.setItem(PIC_KEY, JSON.stringify(data));
      }

      let dataPICs = loadPICs();
      let nextId = dataPICs.length ? Math.max(...dataPICs.map(p => p.id)) + 1 : 1;

      const statusBadge = (cell) => {
        const val = cell.getValue();
        const color = val === 'aktif' ? 'success' : 'secondary';
        const label = val === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        return `<span class="badge text-bg-${color}">${label}</span>`;
      };

      const btnAksi = (cell) => {
        const id = cell.getValue();
        return `<button class="btn btn-sm btn-warning" onclick="toggleDropdownPIC(event, ${id})">
          Aksi <i class="bi bi-chevron-down ms-1"></i>
        </button>`;
      };

      let activePICRowId = null;

      function toggleDropdownPIC(e, id) {
        e.stopPropagation();
        const dd = document.getElementById('custom-dropdown-pic');
        const rect = e.currentTarget.getBoundingClientRect();
        
        if (activePICRowId === id && dd.style.display === 'block') {
          dd.style.display = 'none'; 
          activePICRowId = null; 
          return;
        }

        // PERBAIKAN 1: Pindah halaman ke edit-user.php dan bawa parameter ID-nya
        // Pastikan pemanggilan ID elemennya benar ('dd-ubah')
        document.getElementById('dd-ubah').onclick = (ev) => { 
            ev.preventDefault(); 
            window.location.href = `edit-user.php?id=${id}`; 
        };

        document.getElementById('ddp-hapus').onclick = (ev) => {
          ev.preventDefault();
          if (confirm('Hapus kontak PIC ini?')) {
            const row = table.getRow(id);
            if (row) row.delete();
            dataPICs = dataPICs.filter(p => p.id !== id);
            savePICs(dataPICs);
            dd.style.display = 'none'; 
            activePICRowId = null;
          }
        };

        dd.style.display = 'block';
        dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
        dd.style.left = (rect.left + window.scrollX - 40) + 'px';
        activePICRowId = id;
      }

      // ... (kode inisialisasi tabel dibiarkan sama seperti milik Anda) ...

      document.addEventListener('DOMContentLoaded', () => {
        table = new Tabulator('#users-table', {
          theme: 'bootstrap5',
          data: dataPICs,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50],
          movableColumns: false,

          paginationCounter: function(pageSize, currentRow, currentPage, totalRows, totalPages) {
            const totalDataKeseluruhan = table.getData().length;
            return `Menampilkan ${pageSize} Data dari ${totalRows} Data, Total Data adalah ${totalDataKeseluruhan}`;
          },

          columns: [
            { title: 'No.',         field: 'id',         headerHozAlign: 'center', hozAlign: 'center', width: 80 },
            { title: 'Nama Lengkap',field: 'nama',      headerHozAlign: 'left',   hozAlign: 'left' },
            { title: 'No. Telepon', field: 'no_telp',   headerHozAlign: 'left',   hozAlign: 'left' },
            { title: 'Email',      field: 'email',      headerHozAlign: 'left',   hozAlign: 'left' },
            { title: 'Jabatan',    field: 'jabatan',    headerHozAlign: 'left',   hozAlign: 'left' },
            { title: 'Status',     field: 'status',     formatter: statusBadge, headerHozAlign: 'center', hozAlign: 'center', width: 100 },
            { title: 'Aksi',       field: 'id',         formatter: btnAksi, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 120 },
          ],
        });

        // PERBAIKAN 2: Search Filter (Menghapus 'search-departemen' yang bikin error)
        function applySearch() {
          const nama       = document.getElementById('search-nama').value.trim();
          const status     = document.getElementById('search-status').value;
          const filters    = [];
          
          if (nama)   filters.push({ field: 'nama',   type: 'like', value: nama });
          if (status) filters.push({ field: 'status', type: '=',    value: status });
          
          filters.length > 0 ? table.setFilter(filters) : table.clearFilter();
        }
        
        document.getElementById('btn-search').addEventListener('click', applySearch);
        document.getElementById('search-nama').addEventListener('input', applySearch);
        document.getElementById('search-status').addEventListener('change', applySearch);
        
        document.getElementById('btn-reset').addEventListener('click', () => {
          document.getElementById('search-nama').value   = '';
          document.getElementById('search-status').value = '';
          table.clearFilter();
        });

        // Export Buttons
        document.getElementById('export-csv').addEventListener('click', () => table.download('csv', 'data_pic.csv'));
        document.getElementById('export-json').addEventListener('click', () => table.download('json', 'data_pic.json'));
      });
    </script>
</body>
</html>