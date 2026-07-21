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

  /* Dropdown "Cetak": dikasih warna solid + kontras tinggi & z-index tegas,
     supaya selalu jelas kelihatan saat dibuka (terlepas dari tema gelap/terang). */
  .dropdown-cetak .dropdown-menu {
    --bs-dropdown-bg: #1c2333;
    --bs-dropdown-color: #e5e7eb;
    --bs-dropdown-link-color: #e5e7eb;
    --bs-dropdown-link-hover-bg: #198754;
    --bs-dropdown-link-hover-color: #ffffff;
    --bs-dropdown-link-active-bg: #198754;
    --bs-dropdown-link-active-color: #ffffff;
    --bs-dropdown-border-color: rgba(255, 255, 255, 0.15);
    z-index: 1055;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  }
  .dropdown-cetak .dropdown-item i {
    color: inherit;
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
          <div class="dropdown dropdown-cetak">
            <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="bi bi-printer"></i> Cetak
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a id="btn-cetak-dompdf" class="dropdown-item" href="#" target="_blank"><i class="bi bi-printer me-2"></i>Print Faktur</a></li>
              <li><a id="btn-download-dompdf" class="dropdown-item" href="#"><i class="bi bi-download me-2"></i>Generate PDF</a></li>
              <li><a id="btn-cetak-kwitansi" class="dropdown-item" href="../pembayaran/cetak-kwitansi.php" target="_blank"><i class="bi bi-receipt me-2"></i>Kwitansi</a></li>
            </ul>
          </div>
          <a href="edit-invoice.php" class="btn btn-outline-warning" title="Ubah Faktur">
            <i class="bi bi-pencil-square"></i>
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
                  <dt class="col-7 text-secondary fw-normal pt-2">Sudah Dibayar</dt>
                  <dd class="col-5 text-end text-success pt-2 mb-0" id="total-terbayar">Rp 0</dd>
                  <dt class="col-7 fw-semibold border-top pt-2">Sisa Tagihan</dt>
                  <dd class="col-5 text-end fw-semibold border-top pt-2 mb-0 text-danger" id="total-sisa">Rp 0</dd>
                </dl>
              </div>
            </div>

            <div class="d-print-none" id="riwayat-bayar-wrapper" style="display:none;">
              <hr>
              <p class="small text-secondary mb-2">
                <i class="bi bi-clock-history me-1"></i>Riwayat Pembayaran
              </p>
              <ul class="list-group list-group-flush mb-0" id="riwayat-bayar-list"></ul>
            </div>
          </div>
          <div class="mx-4 mb-3 d-print-none text-end" style="padding: 1vw ">
              <button type="button" class="btn btn-lg btn-success" id="btn-bayar-sekarang" data-bs-toggle="modal" data-bs-target="#modalBayar">
                <i class="bi bi-credit-card"></i> Bayar Sekarang
              </button>
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
  <!-- Modal Bayar Sekarang: satu langkah, tanpa pindah halaman -->
  <div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBayarLabel"><i class="bi bi-credit-card me-2"></i>Bayar Faktur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-sm-4">
              <p class="text-secondary small mb-1">No. Faktur</p>
              <p class="fw-semibold mb-0" id="bayar-inv-no">-</p>
            </div>
            <div class="col-sm-4">
              <p class="text-secondary small mb-1">Total Tagihan</p>
              <p class="fw-semibold mb-0" id="bayar-total">Rp 0</p>
            </div>
            <div class="col-sm-4">
              <p class="text-secondary small mb-1">Sisa yang harus dibayar</p>
              <p class="fw-bold text-danger mb-0" id="bayar-sisa">Rp 0</p>
            </div>
          </div>

          <div class="alert alert-success py-2 small d-none" id="bayar-alert-lunas">
            <i class="bi bi-check-circle me-1"></i>Faktur ini sudah lunas.
          </div>

          <form id="form-bayar-modal">
            <div class="row">
              <div class="col-sm-6 mb-3">
                <label class="form-label">Tanggal Pembayaran*</label>
                <input type="date" class="form-control" id="bayar-tanggal" required>
              </div>
              <div class="col-sm-6 mb-3">
                <label class="form-label">Nominal Dibayar*</label>
                <input type="number" class="form-control" id="bayar-nominal" min="1" placeholder="Masukkan nominal" required>
                <div class="form-text" id="bayar-nominal-help">Sisa tagihan akan berkurang otomatis setelah disimpan.</div>
              </div>
              <div class="col-sm-6 mb-3">
                <label class="form-label">Metode Pembayaran*</label>
                <select class="form-select" id="bayar-metode" required>
                  <option value="" disabled selected>-- Pilih Metode --</option>
                  <option value="Tunai">Tunai</option>
                  <option value="Transfer Bank">Transfer Bank</option>
                  <option value="QRIS">QRIS</option>
                  <option value="Kartu Debit">Kartu Debit</option>
                  <option value="Kartu Kredit">Kartu Kredit</option>
                </select>
              </div>
              <div class="col-sm-6 mb-3">
                <label class="form-label">No. Referensi / Bukti</label>
                <input type="text" class="form-control" id="bayar-referensi" placeholder="Opsional, contoh: kode transfer">
              </div>
              <div class="col-12 mb-0">
                <label class="form-label">Catatan</label>
                <textarea class="form-control" id="bayar-catatan" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-success" id="btn-simpan-bayar">
            <i class="bi bi-check-lg me-1"></i>Simpan Pembayaran
          </button>
        </div>
      </div>
    </div>
  </div>

  <?php include "../../layout/footer.php"; ?>

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

      // ==== Daftarkan/sinkronkan faktur ini ke DummyDB ====
      // Ini yang tadinya bikin bug: faktur baru dari "Tambah Faktur" belum
      // pernah tercatat di DummyDB, jadi modal "Bayar Sekarang" tidak
      // menemukan datanya (nominal & total selalu Rp 0, tombol simpan diam).
      // Sekarang setiap kali barang ditambah/diubah/dihapus, total faktur
      // otomatis disinkronkan, dan ringkasan pembayaran ikut diperbarui.
      if (window.DummyDB) {
        const invNoAktif = document.getElementById('inv-number').textContent.trim();
        const customerAktif = document.getElementById('inv-customer').textContent.trim();
        DummyDB.saveItems(invNoAktif, items); // ← barang disimpan, tidak lagi reset tiap reload

        // "-" adalah placeholder default sebelum data pelanggan termuat —
        // jangan sampai ini ikut tersimpan sebagai nama pelanggan asli
        // (bikin baris "hantu" tanpa nama di halaman Tunggakan/Pembayaran).
        const payload = {
          inv_no: invNoAktif,
          due_date: document.getElementById('inv-due').textContent.trim(),
          total: grand,
        };
        if (customerAktif && customerAktif !== '-') payload.customer = customerAktif;
        DummyDB.upsertInvoice(payload);

        if (typeof window.refreshInvoiceSummary === 'function') {
          window.refreshInvoiceSummary();
        }
      }
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
      const invNo = params.get('inv_no');

      // ==== Faktur tidak valid: JANGAN diam-diam pakai data faktur lain ====
      // Sebelumnya kalau inv_no kosong/hilang dari URL, sistem fallback ke
      // 'INV-2026-001' — artinya bisa menampilkan data pelanggan lain tanpa
      // sepengetahuan user. Sekarang kalau nomor faktur tidak ada, halaman
      // berhenti di sini dan kasih pesan yang jelas.
      if (!invNo) {
        document.querySelector('.app-content .container-fluid').innerHTML = `
          <div class="alert alert-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            <div>
              <strong>Nomor faktur tidak ditemukan.</strong><br>
              Faktur ini kemungkinan rusak/tidak lengkap. Silakan kembali ke daftar faktur dan buka lagi lewat menu "Detail".
              <br><a href="table-invoice.php" class="alert-link">&larr; Kembali ke Daftar Faktur</a>
            </div>
          </div>`;
        return;
      }

      document.getElementById('inv-number').textContent = invNo;
      if (params.get('customer')) document.getElementById('inv-customer').textContent = params.get('customer');
      if (params.get('due_date')) document.getElementById('inv-due').textContent = params.get('due_date');

      // ==== PERBAIKAN: LOGIKA UNTUK MENAMPILKAN PIC USER ====
      // Sistem akan mencoba mengambil PIC dari parameter URL (?pic=Nama), 
      // atau dari session localStorage (jika user login), 
      // atau fallback menggunakan default user 'Amelia Price'.
      const activePIC = params.get('pic') || localStorage.getItem('active_user') || 'Zidan Rasyid Susanto';
      document.getElementById('inv-pic').textContent = activePIC;
      // =======================================================

      // ==== Ambil status, total, terbayar, sisa dari DummyDB (bukan lagi statis) ====
      const statusMap = {
        paid:      ['Lunas', 'success'],
        partial:   ['Sebagian', 'info'],
        unpaid:    ['Belum Lunas', 'warning'],
        cancelled: ['Dibatalkan', 'secondary'],
      };

      function renderStatusBadge(status) {
        const badge = document.getElementById('inv-status');
        const [label, color] = statusMap[status] || ['-', 'secondary'];
        badge.className = `badge text-bg-${color} mt-2`;
        badge.textContent = label;
      }

      function renderRiwayatBayar(invNoAktif) {
        const list = document.getElementById('riwayat-bayar-list');
        const wrapper = document.getElementById('riwayat-bayar-wrapper');
        const riwayat = DummyDB.getPayments(invNoAktif);

        if (!riwayat.length) {
          wrapper.style.display = 'none';
          return;
        }

        wrapper.style.display = 'block';
        list.innerHTML = riwayat.map((p) => `
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span>
              <span class="fw-semibold">${DummyDB.fmt(p.nominal)}</span>
              <span class="text-secondary small ms-1">${p.metode} · ${p.tanggal}</span>
            </span>
            ${p.referensi ? `<span class="text-secondary small">Ref: ${p.referensi}</span>` : ''}
          </li>`).join('');
      }

      function refreshInvoiceSummary() {
        const inv = DummyDB.getInvoiceByNo(invNo);
        if (!inv) return;

        renderStatusBadge(inv.status);
        document.getElementById('total-terbayar').textContent = DummyDB.fmt(inv.terbayar);
        document.getElementById('total-sisa').textContent = DummyDB.fmt(inv.sisa);
        renderRiwayatBayar(invNo);

        // Tombol "Bayar Sekarang" otomatis nonaktif kalau sudah lunas/dibatalkan
        const btnBayar = document.getElementById('btn-bayar-sekarang');
        const sudahSelesai = inv.status === 'paid' || inv.status === 'cancelled';
        btnBayar.disabled = sudahSelesai;
        btnBayar.classList.toggle('disabled', sudahSelesai);

        return inv;
      }

      window.refreshInvoiceSummary = refreshInvoiceSummary;
      refreshInvoiceSummary();

      // ==== Isi modal setiap kali dibuka, supaya datanya selalu terbaru ====
      document.getElementById('modalBayar').addEventListener('show.bs.modal', (e) => {
        const inv = DummyDB.getInvoiceByNo(invNo);
        if (!inv || inv.total <= 0) {
          e.preventDefault();
          DummyDB.showToast('Tambahkan barang terlebih dahulu sebelum melakukan pembayaran.', 'error');
          return;
        }
        document.getElementById('bayar-inv-no').textContent = invNo;
        document.getElementById('bayar-total').textContent = DummyDB.fmt(inv.total);
        document.getElementById('bayar-sisa').textContent = DummyDB.fmt(inv.sisa);
        document.getElementById('bayar-tanggal').value = new Date().toISOString().slice(0, 10);
        document.getElementById('bayar-nominal').value = inv.sisa;
        document.getElementById('bayar-nominal').max = inv.sisa;
        document.getElementById('bayar-metode').value = '';
        document.getElementById('bayar-referensi').value = '';
        document.getElementById('bayar-catatan').value = '';
        document.getElementById('bayar-alert-lunas').classList.toggle('d-none', inv.sisa > 0);
      });

      // ==== Validasi nominal real-time: cegah input melebihi sisa tagihan ====
      document.getElementById('bayar-nominal').addEventListener('input', function () {
        const inv = DummyDB.getInvoiceByNo(invNo);
        if (!inv) return;
        const help = document.getElementById('bayar-nominal-help');
        const nilai = Number(this.value || 0);

        if (nilai > inv.sisa) {
          this.classList.add('is-invalid');
          help.textContent = `Nominal melebihi sisa tagihan (maks. ${DummyDB.fmt(inv.sisa)}).`;
          help.classList.add('text-danger');
        } else {
          this.classList.remove('is-invalid');
          help.textContent = `Sisa setelah dibayar: ${DummyDB.fmt(Math.max(inv.sisa - nilai, 0))}`;
          help.classList.remove('text-danger');
        }
      });

      // ==== Simpan pembayaran → tersimpan ke DummyDB, badge & total update instan, toast, tutup modal ====
      document.getElementById('btn-simpan-bayar').addEventListener('click', () => {
        const form = document.getElementById('form-bayar-modal');
        if (!form.reportValidity()) return;

        const inv = DummyDB.getInvoiceByNo(invNo);
        if (!inv) {
          DummyDB.showToast('Faktur belum memiliki tagihan. Tambahkan barang terlebih dahulu.', 'error');
          return;
        }
        const nominal = Number(document.getElementById('bayar-nominal').value || 0);

        if (nominal <= 0 || nominal > inv.sisa) {
          DummyDB.showToast('Nominal pembayaran tidak valid.', 'error');
          return;
        }

        const payment = DummyDB.addPayment({
          inv_no: invNo,
          tanggal: document.getElementById('bayar-tanggal').value,
          nominal,
          metode: document.getElementById('bayar-metode').value,
          referensi: document.getElementById('bayar-referensi').value.trim(),
          catatan: document.getElementById('bayar-catatan').value.trim(),
        });

        bootstrap.Modal.getInstance(document.getElementById('modalBayar')).hide();

        const updated = refreshInvoiceSummary();

        DummyDB.showToast(
          `Pembayaran ${DummyDB.fmt(nominal)} berhasil dicatat untuk ${invNo}` +
          (updated.status === 'paid' ? ' — faktur kini Lunas.' : '.')
        );

        // Tautkan tombol Kwitansi ke data pembayaran yang baru saja disimpan
        const linkKwitansi = document.getElementById('btn-cetak-kwitansi');
        const qp = new URLSearchParams({
          inv_no: invNo,
          customer: document.getElementById('inv-customer').textContent,
          nominal: payment.nominal,
          tanggal: payment.tanggal,
          metode: payment.metode,
        });
        linkKwitansi.href = `../pembayaran/cetak-kwitansi.php?${qp.toString()}`;
      });

      document.getElementById('inv-date').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

      // Muat barang yang sudah tersimpan untuk faktur ini (kalau ada),
      // supaya total tidak ke-reset ke Rp0 setiap halaman dibuka ulang.
      items = DummyDB.getItems(invNo);
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

      // Inisialisasi eksplisit dropdown "Cetak" (jaga-jaga kalau auto-init
      // dari atribut data-bs-toggle sempat tertimpa/tidak jalan).
      const toggleCetak = document.querySelector('.dropdown-cetak .dropdown-toggle');
      if (toggleCetak && !bootstrap.Dropdown.getInstance(toggleCetak)) {
        new bootstrap.Dropdown(toggleCetak);
      }
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