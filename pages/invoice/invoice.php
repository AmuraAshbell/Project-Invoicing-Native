<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Detail</title>
    <link rel="stylesheet" href="../../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/css/tabulator_bootstrap5.min.css" crossorigin="anonymous"/>

    <style>
  /* Konfigurasi Khusus Saat Mode Print (Ctrl + P) */
  @media print {
    /* 1. Sembunyikan Sidebar, Navbar, dan Footer AdminLTE */
    .app-header, .app-sidebar, .app-footer, .breadcrumb {
      display: none !important;
    }
    
    /* 2. Reset margin dan padding konten agar full kertas */
    .app-main, .app-wrapper, .app-content {
      margin: 0 !important;
      padding: 0 !important;
      background-color: white !important;
    }
    
    /* 3. Hilangkan border bayangan pada Card */
    .card {
      border: none !important;
      box-shadow: none !important;
    }
    
    /* 4. Paksa warna background (seperti badge/bg-light) tetap tercetak */
    * {
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }
    
    /* 5. Atur ukuran margin kertas A4 */
    @page {
      size: A4;
      margin: 1cm;
    }
  }
</style>
</head>
<body class="app-wrapper">
  <?php include "../../layout/navbar.php"; ?>
  <?php include "../../layout/sidebar.php"; ?>

  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Detail Faktur</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
              <li class="breadcrumb-item"><a href="table-invoice.php">Faktur</a></li>
              <li class="breadcrumb-item active">Detail Faktur</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="d-flex justify-content-end gap-2 mb-3 d-print-none">
          <a id="btn-cetak-dompdf" href="#" target="_blank" class="btn btn-outline-success">
            <i class="bi bi-printer"></i> Print
          </a>
          <a id="btn-download-dompdf" href="#" class="btn btn-outline-success" style="margin-right: 5px;">
            <i class="bi bi-download"></i> Generate PDF
          </a>
          <a href="../pembayaran/cetak-kwitansi.php" class="btn btn-outline-success">
            <i class="bi bi-receipt me-1"></i> Kwitansi
          </a>
          <a href="edit-invoice.php" class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> Ubah Faktur
          </a>
        </div>

        <div class="card">
          <div class="card-body p-4 p-md-5">
            <div class="row mb-4">
    <div class="col-sm-6 mb-3 mb-sm-0 d-flex flex-column align-items-start">
        
        <img src="../../assets/logo.png" alt="Logo Amura Store" 
             style="max-height: 100px; width: auto; margin-left: -15px;" 
             class="mb-2">
        
        <p class="text-secondary mb-0 small" style="line-height: 1.5;">
            Jl. Tunjungan No. 1, Surabaya<br/>
            Jawa Timur 60275<br/>
            admin@amurastore.id
        </p>
    </div>
    
    <div class="col-sm-6 text-sm-end d-flex flex-column align-items-sm-end justify-content-center">
        <h1 class="h2 mb-1">Faktur</h1>
        <p class="text-secondary mb-0">
            <span class="fw-semibold">#</span><span id="inv-number">INV-2026-00428</span>
        </p>
        <div>
            <span class="badge text-bg-warning mt-2" id="inv-status">Belum Lunas</span>
        </div>
    </div>
</div>

            <div class="row mb-4 p-2 bg-dark rounded">
              
              <div class="col-sm-4 p-1">
                <p class="text-secondary small mb-1">Tagihan kepada</p>
                <p class="mb-0 fw-semibold" id="inv-customer">-</p>
              </div>
              
              <div class="col-sm-4 offset-sm-4 text-sm-end mb-3">
                <p class="text-secondary small mb-1">Tanggal dibuat</p>
                <p class="mb-2 fw-semibold" id="inv-date">-</p>
                
                <p class="text-secondary small mb-1">Tanggal jatuh tempo</p>
                <p class="mb-3 fw-semibold text-danger" id="inv-due">-</p>

                <p class="text-secondary small mb-1">Ditangani Oleh</p>
                <p class="mb-0 fw-bold text-primary">
                  <span id="inv-pic">Memuat...</span> <i class="bi bi-person-badge ms-1"></i>
                </p>
              </div>
              
            </div>

            <div class="table-responsive mb-2">
              <table class="table align-middle mb-0" id="items-table">
                <thead>
                  <tr>
                    <th class="border-top-0">Nama Barang</th>
                    <th class="border-top-0 text-end" style="width:6rem">Jumlah</th>
                    <th class="border-top-0 text-end" style="width:10rem">Harga Satuan</th>
                    <th class="border-top-0 text-end" style="width:10rem">Subtotal</th>
                    <th class="border-top-0 d-print-none" style="width:6rem"></th>
                  </tr>
                </thead>
                <tbody id="items-body">
                </tbody>
              </table>
            </div>

            <div class="my-4 d-print-none">
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                <i class="bi bi-plus-lg me-1"></i>Tambah Barang
              </button>
            </div>

            <div class="row justify-content-end">
              <div class="col-md-5 col-lg-4">
                <dl class="row mb-0">
                  <dt class="col-7 text-secondary fw-normal">Subtotal</dt>
                  <dd class="col-5 text-end mb-2" id="total-subtotal">Rp 0</dd>
                  <dt class="col-7 fw-semibold border-top pt-2">Total</dt>
                  <dd class="col-5 text-end fw-semibold border-top pt-2 mb-0" id="total-grand">Rp 0</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="mx-4 mb-3 d-print-none text-end" style="padding: 1vw ">
              <a href="../pembayaran/form-pembayaran.php" class="btn btn-lg btn-success">
                <i class="bi bi-credit-card"></i> Bayar Sekarang
              </a>
            </div>
        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="namaBarang" class="form-label">Nama Barang*</label>
            <select class="form-select" id="namaBarang">
              <option value="" data-harga="0" selected disabled>-- Pilih Barang --</option>
              <option value="RG 1/144 RX-93 v Gundam (Nu Gundam)" data-harga="650000">RG 1/144 RX-93 v Gundam (Nu Gundam)</option>
              <option value="MG 1/100 Eclipse Gundam" data-harga="780000">MG 1/100 Eclipse Gundam</option>
              <option value="HG 1/144 Gundam Aerial (The Witch from Mercury)" data-harga="240000">HG 1/144 Gundam Aerial (The Witch from Mercury)</option>
              <option value="MGSD Freedom Gundam" data-harga="620000">MGSD Freedom Gundam</option>
              <option value="PG Unchained 1/60 RX-78-2 Gundam Unleashed" data-harga="3950000">PG Unchained 1/60 RX-78-2 Gundam Unleashed</option>
              <option value="HGCE 1/144 Rising Freedom Gundam" data-harga="360000">HGCE 1/144 Rising Freedom Gundam</option>
              <option value="MG 1/100 MSN-04 Sazabi Ver.Ka" data-harga="1450000">MG 1/100 MSN-04 Sazabi Ver.Ka</option>
              <option value="RG 1/144 God Gundam" data-harga="580000">RG 1/144 God Gundam</option>
              <option value="EG 1/144 RX-78-2 Gundam" data-harga="110000">EG 1/144 RX-78-2 Gundam</option>
              <option value="MG 1/100 Gundam Barbatos" data-harga="680000">MG 1/100 Gundam Barbatos</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jumlahBarang" class="form-label">Jumlah*</label>
            <input type="number" class="form-control" id="jumlahBarang" min="1" value="1">
          </div>
          <div class="mb-3">
            <label for="hargaSatuan" class="form-label">Harga Satuan*</label>
            <input type="number" class="form-control" id="hargaSatuan" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="btnSimpanBarang">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalUbahBarang" tabindex="-1" aria-labelledby="modalUbahBarangLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUbahBarangLabel">Ubah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="ubahIndex">
          <div class="mb-3">
            <label for="ubahNamaBarang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="ubahNamaBarang" placeholder="Masukkan nama barang">
          </div>
          <div class="mb-3">
            <label for="ubahJumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="ubahJumlah" min="1">
          </div>
          <div class="mb-3">
            <label for="ubahHarga" class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" id="ubahHarga" min="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-warning" id="btnSimpanUbah">Ubah</button>
        </div>
      </div>
    </div>
  </div>
  <?php include "../../layout/footer.php"; ?>

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

  <script>
    const fmt = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);
    let items = [];

    function renderItems() {
      const tbody = document.getElementById('items-body');
      tbody.innerHTML = '';
      let grand = 0;

      items.forEach((item, i) => {
        const sub = item.jumlah * item.harga;
        grand += sub;
        tbody.innerHTML += `
          <tr>
            <td><p class="mb-0 fw-semibold">${item.nama}</p></td>
            <td class="text-end">${item.jumlah}</td>
            <td class="text-end">${fmt(item.harga)}</td>
            <td class="text-end fw-semibold">${fmt(sub)}</td>
            <td class="text-end d-print-none">
              <button class="btn btn-sm btn-outline-warning py-0 px-1 me-1" onclick="bukaModalUbah(${i})">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger py-0 px-1" onclick="hapusItem(${i})">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>`;
      });

      document.getElementById('total-subtotal').textContent = fmt(grand);
      document.getElementById('total-grand').textContent = fmt(grand);
    }

    function hapusItem(i) {
      items.splice(i, 1);
      renderItems();
    }

    function bukaModalUbah(i) {
      const item = items[i];
      document.getElementById('ubahIndex').value = i;
      document.getElementById('ubahNamaBarang').value = item.nama;
      document.getElementById('ubahJumlah').value = item.jumlah;
      document.getElementById('ubahHarga').value = item.harga;
      new bootstrap.Modal(document.getElementById('modalUbahBarang')).show();
    }

    document.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);
      
      // Ambil data pelanggan & jatuh tempo
      if (params.get('inv_no')) document.getElementById('inv-number').textContent = params.get('inv_no');
      if (params.get('customer')) document.getElementById('inv-customer').textContent = params.get('customer');
      if (params.get('due_date')) document.getElementById('inv-due').textContent = params.get('due_date');

      // ==== PERBAIKAN: LOGIKA UNTUK MENAMPILKAN PIC USER ====
      // Sistem akan mencoba mengambil PIC dari parameter URL (?pic=Nama), 
      // atau dari session localStorage (jika user login), 
      // atau fallback menggunakan default user 'Amelia Price'.
      const activePIC = params.get('pic') || localStorage.getItem('active_user') || 'Zidan Rasyid Susanto';
      document.getElementById('inv-pic').textContent = activePIC;
      // =======================================================

      const invNo = params.get('inv_no') || 'INV-2026-001';
      const btnBayar = document.querySelector('a[href*="form-pembayaran.php"]');
      if (btnBayar) {
        btnBayar.href = `../pembayaran/form-pembayaran.php?inv_no=${encodeURIComponent(invNo)}`;
      }

      document.getElementById('inv-date').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

      renderItems();

      document.getElementById('btnSimpanBarang').addEventListener('click', () => {
        const nama   = document.getElementById('namaBarang').value.trim();
        const jumlah = parseInt(document.getElementById('jumlahBarang').value) || 0;
        const harga  = parseInt(document.getElementById('hargaSatuan').value) || 0;

        if (!nama || jumlah <= 0 || harga <= 0) return;

        items.push({ nama, jumlah, harga });
        renderItems();

        document.getElementById('namaBarang').value = '';
        document.getElementById('jumlahBarang').value = '1';
        document.getElementById('hargaSatuan').value = '';

        bootstrap.Modal.getInstance(document.getElementById('modalTambahBarang')).hide();
      });

      document.getElementById('btnSimpanUbah').addEventListener('click', () => {
        const i      = parseInt(document.getElementById('ubahIndex').value);
        const nama   = document.getElementById('ubahNamaBarang').value.trim();
        const jumlah = parseInt(document.getElementById('ubahJumlah').value) || 0;
        const harga  = parseInt(document.getElementById('ubahHarga').value) || 0;

        if (!nama || jumlah <= 0 || harga <= 0) return;

        items[i] = { nama, jumlah, harga };
        renderItems();

        bootstrap.Modal.getInstance(document.getElementById('modalUbahBarang')).hide();
      });
      // =================================================================
    });

    document.addEventListener('DOMContentLoaded', function() {
      const selectBarang = document.getElementById('namaBarang');
      const inputHarga = document.getElementById('hargaSatuan');

      selectBarang.addEventListener('change', function() {
        const opsiTerpilih = this.options[this.selectedIndex];
        const hargaOtomatis = opsiTerpilih.getAttribute('data-harga');
        inputHarga.value = hargaOtomatis;
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Ambil nomor invoice dari URL
      const urlParams = new URLSearchParams(window.location.search);
      const invNo = urlParams.get('inv_no'); 
      
      if(invNo) {
          // Isi otomatis link untuk Cetak (buka tab blank DomPDF)
          document.getElementById('btn-cetak-dompdf').href = `cetak-pdf.php?inv_no=${encodeURIComponent(invNo)}&action=print`;
          
          // Isi otomatis link untuk Download (langsung unduh file DomPDF)
          document.getElementById('btn-download-dompdf').href = `cetak-pdf.php?inv_no=${encodeURIComponent(invNo)}&action=download`;
      }
      
      // ... (kode combobox barang Anda biarkan saja di sini) ...
    });
  </script>
</body>
</html>