<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
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
                            <li class="breadcrumb-item"><a href="../../dashboard.php">Beranda</a></li>
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
                        <h3 class="card-title">Data User</h3>

                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-sm btn-primary" onclick="bukaModalTambah()">
                                <i class="bi bi-plus-lg me-1"></i>Tambah User
                            </button>
                            <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-csv me-1"></i>Export CSV
                            </button>
                            <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-json me-1"></i>Export JSON
                            </button>
                        </div>
                        <!-- Search -->
                        <div class="row g-2 mb-3">
                          <div class="col-12 col-md-3">
                            <label for="search-username" class="form-label form-label-sm mb-1">Username</label>
                            <input type="text" id="search-username" class="form-control form-control-sm" placeholder="Cari username...">
                          </div>
                          <div class="col-12 col-md-4">
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="add-username" placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="add-nama" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="add-password" placeholder="Masukkan password">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="add-status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanTambah">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah -->
    <div class="modal fade" id="modalUbahUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit-username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit-nama">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="edit-status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="btnSimpanUbah">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../../layout/footer.php"; ?>


    <!-- Dropdown custom user -->
    <div id="custom-dropdown-user" class="dropdown-menu shadow" style="display:none; position:fixed; z-index:9999; min-width:160px;">
      <a class="dropdown-item" id="ddu-ubah" href="#"><i class="bi bi-pencil-square me-2"></i>Ubah</a>
      <hr class="dropdown-divider">
      <a class="dropdown-item text-danger" id="ddu-hapus" href="#"><i class="bi bi-trash me-2"></i>Hapus</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
    <script>
      (() => {
        'use strict';
        const STORAGE_KEY = 'lte-theme';
        const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
        const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
        const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
        const getPreferredTheme = () => { const s = getStoredTheme(); if (s) return s; return prefersDark() ? 'dark' : 'light'; };
        const setTheme = (theme) => { const r = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme; document.documentElement.setAttribute('data-bs-theme', r); };
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
      // Data user disimpan di localStorage agar sinkron dengan invoice.php
      const USER_KEY = 'app_users';

      const defaultUsers = [
        { id: 1, username: 'admin',   nama: 'Administrator', status: 'nonaktif'    },
        { id: 2, username: 'zidan',   nama: 'Zidan Rasyid',  status: 'aktif'    },
        { id: 3, username: 'budi_s',  nama: 'Budi Santoso',  status: 'nonaktif'    },
        { id: 4, username: 'citra_d', nama: 'Citra Dewi',    status: 'nonaktif' },
        { id: 5, username: 'fahmi_m', nama: 'Fahmi Malik',   status: 'nonaktif'    },
      ];

      function loadUsers() {
        const stored = localStorage.getItem(USER_KEY);
        return stored ? JSON.parse(stored) : defaultUsers;
      }

      function saveUsers(data) {
        localStorage.setItem(USER_KEY, JSON.stringify(data));
      }

      let dataUsers = loadUsers();
      let nextId = dataUsers.length ? Math.max(...dataUsers.map(u => u.id)) + 1 : 1;

      const statusBadge = (cell) => {
        const val = cell.getValue();
        const color = val === 'aktif' ? 'success' : 'secondary';
        const label = val === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        return `<span class="badge text-bg-${color}">${label}</span>`;
      };

      const btnAksi = (cell) => {
        const id = cell.getValue();
        return `<button class="btn btn-sm btn-warning" onclick="toggleDropdownUser(event, ${id})">
          Aksi <i class="bi bi-chevron-down ms-1"></i>
        </button>`;
      };

      let activeUserRowId = null;

      function toggleDropdownUser(e, id) {
        e.stopPropagation();
        const dd = document.getElementById('custom-dropdown-user');
        const rect = e.currentTarget.getBoundingClientRect();
        if (activeUserRowId === id && dd.style.display === 'block') {
          dd.style.display = 'none'; activeUserRowId = null; return;
        }
        document.getElementById('ddu-ubah').onclick = (ev) => { ev.preventDefault(); bukaModalUbah(id); dd.style.display = 'none'; activeUserRowId = null; };
        document.getElementById('ddu-hapus').onclick = (ev) => {
          ev.preventDefault();
          if (confirm('Hapus user ini?')) {
            const row = table.getRow(id);
            if (row) row.delete();
            dataUsers = dataUsers.filter(u => u.id !== id);
            saveUsers(dataUsers);
            dd.style.display = 'none'; activeUserRowId = null;
          }
        };
        dd.style.display = 'block';
        dd.style.top  = (rect.bottom + window.scrollY + 2) + 'px';
        dd.style.left = (rect.left + window.scrollX) + 'px';
        activeUserRowId = id;
      }

      document.addEventListener('click', () => {
        const dd = document.getElementById('custom-dropdown-user');
        if (dd) dd.style.display = 'none';
        activeUserRowId = null;
      });

      let table;

      document.addEventListener('DOMContentLoaded', () => {
        table = new Tabulator('#users-table', {
          theme: 'bootstrap5',
          data: dataUsers,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50],
          movableColumns: true,
          columns: [
            { title: 'ID',           field: 'id',       headerHozAlign: 'center', hozAlign: 'center', headerSort: true, width: 80 },
            { title: 'Username',     field: 'username', headerHozAlign: 'center', hozAlign: 'center', headerSort: true },
            { title: 'Nama Lengkap', field: 'nama',     headerHozAlign: 'center', hozAlign: 'center', headerSort: false },
            { title: 'Status',       field: 'status',   formatter: statusBadge, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 130 },
            { title: 'Aksi',         field: 'id',       formatter: btnAksi, headerSort: false, headerHozAlign: 'center', hozAlign: 'center', width: 120 },
          ],
        });

        function applySearch() {
          const username = document.getElementById('search-username').value.trim();
          const nama     = document.getElementById('search-nama').value.trim();
          const status   = document.getElementById('search-status').value;
          const filters  = [];
          if (username) filters.push({ field: 'username', type: 'like', value: username });
          if (nama)     filters.push({ field: 'nama',     type: 'like', value: nama });
          if (status)   filters.push({ field: 'status',   type: '=',    value: status });
          filters.length > 0 ? table.setFilter(filters) : table.clearFilter();
        }
        document.getElementById('btn-search').addEventListener('click', applySearch);
        document.getElementById('search-username').addEventListener('input', applySearch);
        document.getElementById('search-nama').addEventListener('input', applySearch);
        document.getElementById('search-status').addEventListener('change', applySearch);
        document.getElementById('btn-reset').addEventListener('click', () => {
          document.getElementById('search-username').value = '';
          document.getElementById('search-nama').value     = '';
          document.getElementById('search-status').value   = '';
          table.clearFilter();
        });

        document.getElementById('export-csv').addEventListener('click', () => table.download('csv', 'users.csv'));
        document.getElementById('export-json').addEventListener('click', () => table.download('json', 'users.json'));

        document.getElementById('btnSimpanTambah').addEventListener('click', () => {
          const username = document.getElementById('add-username').value.trim();
          const nama     = document.getElementById('add-nama').value.trim();
          const status   = document.getElementById('add-status').value;
          if (!username || !nama) return;
          const newUser = { id: nextId++, username, nama, status };
          dataUsers.push(newUser);
          saveUsers(dataUsers);
          table.addRow(newUser);
          document.getElementById('add-username').value = '';
          document.getElementById('add-nama').value     = '';
          document.getElementById('add-password').value = '';
          bootstrap.Modal.getInstance(document.getElementById('modalTambahUser')).hide();
        });

        document.getElementById('btnSimpanUbah').addEventListener('click', () => {
          const id       = parseInt(document.getElementById('edit-id').value);
          const username = document.getElementById('edit-username').value.trim();
          const nama     = document.getElementById('edit-nama').value.trim();
          const status   = document.getElementById('edit-status').value;
          if (!username || !nama) return;
          const row = table.getRow(id);
          if (row) row.update({ username, nama, status });
          const user = dataUsers.find(u => u.id === id);
          if (user) { user.username = username; user.nama = nama; user.status = status; }
          saveUsers(dataUsers);
          bootstrap.Modal.getInstance(document.getElementById('modalUbahUser')).hide();
        });
      });

      function bukaModalTambah() {
        new bootstrap.Modal(document.getElementById('modalTambahUser')).show();
      }

      function bukaModalUbah(id) {
        const user = dataUsers.find(u => u.id === id);
        if (!user) return;
        document.getElementById('edit-id').value       = user.id;
        document.getElementById('edit-username').value = user.username;
        document.getElementById('edit-nama').value     = user.nama;
        document.getElementById('edit-status').value   = user.status;
        new bootstrap.Modal(document.getElementById('modalUbahUser')).show();
      }
    </script>
</body>
</html>