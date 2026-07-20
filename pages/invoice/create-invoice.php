<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah-Invoice</title>
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
          <h3 class="mb-0">Tambah Faktur</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
            <li class="breadcrumb-item"><a href="table-invoice.php">Faktur</a></li>
            <li class="breadcrumb-item active">Tambah Faktur</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="col-md-13 mx-auto">
        <div class="card card-primary card-outline mb-4">
          <div class="card-header">
            <div class="card-title">Tambah Faktur</div>
          </div>
          <form action="invoice.php" method="GET">
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Nomor Faktur*</label>
                <div class="d-flex align-items-center gap-2">
                  <div class="form-control-plaintext fs-5 fw-bold text-primary bg-body-secondary border rounded px-3 py-2 mb-0">
                    <i class="bi bi-upc-scan me-2"></i><span id="noFakturText">Membuat nomor faktur…</span>
                  </div>
                  <button type="button" class="btn btn-outline-secondary" id="btnAcakNoFaktur" title="Buat nomor baru">
                    <i class="bi bi-arrow-clockwise"></i>
                  </button>
                </div>
                <input type="hidden" id="exampleInputRef_No1" name="inv_no" required>
                <div class="form-text">Nomor faktur dibuat otomatis & dijamin unik, tidak perlu diisi manual.</div>
              </div>
              <div class="mb-3">
                <label for="inputCustomer" class="form-label">Nama Pelanggan*</label>
                <select class="form-select" id="inputCustomer" name="customer">
                  <option value="" disabled selected>Pilih Pelanggan</option>
                  <option value="Amelia Price">Amelia Price</option>
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
              <div class="mb-3">
                <label for="inputDueDate" class="form-label">Tanggal Faktur</label>
                <input type="date" class="form-control" id="inputDueDate" name="due_date">
              </div>
              <div class="mb-3">
                <label for="inputDueDate" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="inputDueDate" name="due_date">
              </div>
            </div>
            <div class="card-footer d-flex gap-2">
              <button type="submit" class="btn btn-primary">Kirim</button>
              <a href="table-invoice.php" class="btn btn-secondary">Batal</a>
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
    <script src="../../assets/js/dummy-data.js"></script>
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
      // ==== Nomor faktur otomatis (format INV-####, dijamin unik) ====
      document.addEventListener('DOMContentLoaded', () => {
        const inputNoFaktur = document.getElementById('exampleInputRef_No1'); // hidden, dikirim lewat form
        const teksNoFaktur  = document.getElementById('noFakturText');        // yang ditampilkan ke user
        const btnAcak       = document.getElementById('btnAcakNoFaktur');

        function buatNomorBaru() {
          const nomor = DummyDB.generateInvoiceNumber();
          inputNoFaktur.value = nomor;
          teksNoFaktur.textContent = nomor;
        }

        buatNomorBaru();
        btnAcak.addEventListener('click', buatNomorBaru);

        // Jaga-jaga: cek keunikan sekali lagi tepat sebelum form dikirim
        // (mis. kalau di tab lain sempat ada faktur baru dibuat di rentang
        // waktu yang sama), supaya tidak ada 2 faktur dengan nomor sama.
        document.querySelector('form').addEventListener('submit', (e) => {
          if (DummyDB.invoiceExists(inputNoFaktur.value)) {
            e.preventDefault();
            buatNomorBaru();
            DummyDB.showToast('Nomor faktur sebelumnya sudah dipakai, sudah dibuatkan nomor baru. Silakan klik Kirim lagi.', 'error');
          }
        });
      });
    </script>
</body>
</html>