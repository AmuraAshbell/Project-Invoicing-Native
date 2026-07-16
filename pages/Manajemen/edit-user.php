<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah-Data</title>
    <link rel="stylesheet" href="../../style/style.css">

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
          <h3 class="mb-0">Ubah Pengguna</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
            <li class="breadcrumb-item"><a href="user-manajemen.php">Pengguna</a></li>
            <li class="breadcrumb-item active">Ubah Pengguna</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="col-md-13    mx-auto">
        <div class="card card-primary card-outline mb-4">
          <div class="card-header">
            <div class="card-title">Ubah Pengguna</div>
          </div>
          <form action="user-manajemen.php" method="GET">
            <div class="card-body">
              <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Username*</label>
                <input type="text" class="form-control" id="exampleInputName1" placeholder="Masukkan Username">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="add-email" placeholder="email@contoh.com">
              </div>
              <div class="mb-3">
                  <label for="inputPassword" class="form-label">Password*</label>
                  <div class="input-group">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Masukkan Password" required>
                      <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                          <i class="bi bi-eye" id="iconPassword"></i>
                      </button>
                  </div>
              </div>
              <div class="mb-3">
                  <label for="inputPassword" class="form-label">Konfirmasi Password*</label>
                  <div class="input-group">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Masukkan Konfirmasi Password" required>
                      <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                          <i class="bi bi-eye" id="iconPassword"></i>
                      </button>
                  </div>
              </div>
            </div>
            <div class="card-footer d-flex gap-2">
              <button type="submit" class="btn btn-primary">Ubah</button>
              <a href="user-manajemen.php" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/adminlte.js"></script>
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
    <script>
    // Fitur Show/Hide Password
    const btnTogglePassword = document.getElementById('btnTogglePassword');
    const inputPassword = document.getElementById('inputPassword');
    const iconPassword = document.getElementById('iconPassword');

    btnTogglePassword.addEventListener('click', function () {
        // Cek apakah tipe input saat ini adalah 'password'
        if (inputPassword.type === 'password') {
            // Ubah tipe jadi 'text' agar password terlihat
            inputPassword.type = 'text';
            // Ganti ikon menjadi mata dicoret (eye-slash)
            iconPassword.classList.remove('bi-eye');
            iconPassword.classList.add('bi-eye-slash');
        } else {
            // Kembalikan tipe menjadi 'password' agar tersembunyi lagi
            inputPassword.type = 'password';
            // Ganti ikon menjadi mata biasa (eye)
            iconPassword.classList.remove('bi-eye-slash');
            iconPassword.classList.add('bi-eye');
        }
    });
</script>
</body>
</html>