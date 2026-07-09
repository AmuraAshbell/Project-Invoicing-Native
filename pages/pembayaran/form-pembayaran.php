<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pembayaran</title>
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
            <h3 class="mb-0">Input Pembayaran</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="../beranda/dashboard.php">Beranda</a></li>
              <li class="breadcrumb-item"><a href="pembayaran.php">Pembayaran</a></li>
              <li class="breadcrumb-item active">Bayar</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="col-md-13 mx-auto">

          <!-- Pesan jika tidak ada inv_no di URL -->
          <div class="alert alert-danger d-none" id="alert-invoice-kosong">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Invoice tidak ditemukan. Silakan kembali ke halaman
            <a href="pembayaran.php" class="alert-link">Pembayaran</a> dan pilih faktur yang valid.
          </div>

          <form id="form-pembayaran" action="../invoice/invoice.php" method="GET">

            <input type="hidden" id="inputInvoiceHidden" name="inv_no">

            <!-- ── Data Pembeli ── -->
            <div class="card card-primary card-outline" id="card-pembeli">
              <div class="card-header">
                <div class="card-title">Data Pembeli</div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-4 mb-3">
                    <p class="text-secondary small mb-1">Nama Pembeli*</p>
                    <p class="mb-0 fw-semibold" id="info-nama">-</p>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <p class="text-secondary small mb-1">Nomor Telepon*</p>
                    <p class="mb-0 fw-semibold" id="info-telepon">-</p>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <p class="text-secondary small mb-1">Alamat*</p>
                    <p class="mb-0 fw-semibold" id="info-alamat">-</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- ── Detail Pesanan ── -->
            <div class="card card-outline" id="card-pesanan">
              <div class="card-header">
                <div class="card-title">Detail Pesanan</div>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-6">
                    <p class="text-secondary small mb-1">ID Invoice*</p>
                    <p class="mb-0 fw-semibold">#<span id="info-inv-no">-</span></p>
                  </div>
                  <div class="col-sm-6 text-sm-end">
                    <p class="text-secondary small mb-1">Status Faktur</p>
                    <span class="badge" id="info-status">-</span>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Nama Produk</th>
                        <th class="text-end" style="width:6rem">Jumlah</th>
                        <th class="text-end" style="width:10rem">Harga</th>
                        <th class="text-end" style="width:10rem">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody id="pesanan-body"></tbody>
                  </table>
                </div>
                <div class="row justify-content-end mt-3">
                  <div class="col-md-5 col-lg-4">
                    <dl class="row mb-0">
                      <dt class="col-7 fw-semibold border-top pt-2">Total Pembayaran</dt>
                      <dd class="col-5 text-end fw-semibold border-top pt-2 mb-0" id="info-total-tagihan">Rp 0</dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>

            <!-- ── Form Pembayaran ── -->
            <div class="card card-outline mb-4" id="card-bayar">
              <div class="card-header">
                <div class="card-title">Metode Pembayaran</div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="inputTanggalBayar" class="form-label">Tanggal Pembayaran*</label>
                    <input type="date" class="form-control" id="inputTanggalBayar" name="tgl_bayar" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="inputNominal" class="form-label">Nominal Dibayar*</label>
                    <input type="number" class="form-control" id="inputNominal" name="nominal" placeholder="Masukkan nominal" min="0" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="inputMetode" class="form-label">Metode Pembayaran*</label>
                    <select class="form-select" id="inputMetode" name="metode" required>
                      <option value="" disabled selected>-- Pilih Metode --</option>
                      <option value="Tunai">Tunai</option>
                      <option value="Transfer Bank">Transfer Bank</option>
                      <option value="QRIS">QRIS</option>
                      <option value="Kartu Debit">Kartu Debit</option>
                      <option value="Kartu Kredit">Kartu Kredit</option>
                    </select>
                  </div>
                  <!-- <div class="col-sm-6 mb-3">
                    <label for="inputStatus" class="form-label">Status Pembayaran</label>
                    <select class="form-select" id="inputStatus" name="status_bayar" required>
                      <option value="" disabled selected>-- Pilih Status --</option>
                      <option value="pending">Pending</option>
                      <option value="paid">Paid</option>
                      <option value="failed">Failed</option>
                      <option value="canceled">Canceled</option>
                    </select>
                  </div> -->
                  <div class="col-sm-6 mb-3">
                    <label for="inputReferensi" class="form-label">No. Referensi / Bukti</label>
                    <input type="text" class="form-control" id="inputReferensi" name="referensi" placeholder="Opsional, contoh: kode transfer">
                  </div>
                  <div class="col-12 mb-0">
                    <label for="inputCatatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="inputCatatan" name="catatan" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-lg me-1"></i>Simpan Pembayaran
                </button>
                <a href="pembayaran.php" class="btn btn-secondary">Batal</a>
              </div>
            </div>

          </form>

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

    // ── Data Dummy Faktur (sinkron dengan table-invoice.php) ──
    const dataFaktur = {
      'INV-2026-001': {
        customer: 'Amelia Price', telepon: '0812-3456-7890', alamat: 'Jl. Merdeka No. 12, Jakarta',
        tanggal: '2026-06-01', due_date: '2026-07-01', status: 'paid', terbayar: 650000,
        items: [{ nama: 'RG 1/144 RX-93 v Gundam', jumlah: 1, harga: 650000 }],
      },
      'INV-2026-002': {
        customer: 'Budi Santoso', telepon: '0813-9876-5432', alamat: 'Jl. Dago No. 45, Bandung',
        tanggal: '2026-06-05', due_date: '2026-07-05', status: 'unpaid', terbayar: 0,
        items: [{ nama: 'MG 1/100 Eclipse Gundam', jumlah: 2, harga: 780000 }],
      },
      'INV-2026-003': {
        customer: 'Citra Dewi', telepon: '0856-4321-8765', alamat: 'Jl. Malioboro No. 88, Yogyakarta',
        tanggal: '2026-06-10', due_date: '2026-07-10', status: 'paid', terbayar: 1200000,
        items: [{ nama: 'HG 1/144 Gundam Aerial', jumlah: 5, harga: 240000 }],
      },
      'INV-2026-004': {
        customer: 'Daniel Wijaya', telepon: '0811-2233-4455', alamat: 'Jl. Basuki Rahmat No. 101, Surabaya',
        tanggal: '2026-06-12', due_date: '2026-07-12', status: 'cancelled', terbayar: 0,
        items: [{ nama: 'MGSD Freedom Gundam', jumlah: 1, harga: 620000 }],
      },
      'INV-2026-005': {
        customer: 'Eka Putri', telepon: '0878-5566-7788', alamat: 'Jl. Gajah Mada No. 23, Semarang',
        tanggal: '2026-06-15', due_date: '2026-07-15', status: 'paid', terbayar: 3950000,
        items: [{ nama: 'PG Unchained 1/60 RX-78-2 Gundam', jumlah: 1, harga: 3950000 }],
      },
      'INV-2026-006': {
        customer: 'Fahmi Malik', telepon: '0821-9988-7766', alamat: 'Jl. Sudirman No. 56, Medan',
        tanggal: '2026-06-18', due_date: '2026-07-18', status: 'unpaid', terbayar: 0,
        items: [{ nama: 'HGCE 1/144 Rising Freedom Gundam', jumlah: 3, harga: 360000 }],
      },
      'INV-2026-007': {
        customer: 'Gita Permata', telepon: '0819-1122-3344', alamat: 'Jl. Pettarani No. 14, Makassar',
        tanggal: '2026-06-20', due_date: '2026-07-20', status: 'paid', terbayar: 1450000,
        items: [{ nama: 'MG 1/100 MSN-04 Sazabi Ver.Ka', jumlah: 1, harga: 1450000 }],
      },
      'INV-2026-008': {
        customer: 'Hendra Wijaya', telepon: '0852-7788-9900', alamat: 'Jl. Teuku Umar No. 9, Denpasar',
        tanggal: '2026-06-22', due_date: '2026-07-22', status: 'unpaid', terbayar: 300000,
        items: [
          { nama: 'RG 1/144 God Gundam', jumlah: 1, harga: 580000 },
          { nama: 'EG 1/144 RX-78-2 Gundam', jumlah: 5, harga: 110000 },
        ],
      },
      'INV-2026-009': {
        customer: 'Indah Lestari', telepon: '0813-4455-6677', alamat: 'Jl. Ahmad Yani No. 72, Banjarmasin',
        tanggal: '2026-06-25', due_date: '2026-07-25', status: 'paid', terbayar: 1100000,
        items: [{ nama: 'MG 1/100 Gundam Barbatos', jumlah: 1, harga: 680000 }, { nama: 'HGUC 1/144 RX-0 Unicorn Gundam', jumlah: 1, harga: 280000 }, { nama: 'RG 1/144 MSN-04 Sazabi', jumlah: 1, harga: 140000 }],
      },
      'INV-2026-010': {
        customer: 'Joko Anwar', telepon: '0888-1234-5678', alamat: 'Jl. Pemuda No. 5, Palembang',
        tanggal: '2026-06-28', due_date: '2026-07-28', status: 'cancelled', terbayar: 0,
        items: [{ nama: 'MG 1/100 Dynames Gundam', jumlah: 1, harga: 650000 }],
      },
    };

    const statusMap = {
      paid:      ['Lunas', 'success'],
      unpaid:    ['Belum Lunas', 'warning'],
      cancelled: ['Dibatalkan', 'secondary'],
    };

    document.addEventListener('DOMContentLoaded', () => {
      // ── Ambil inv_no langsung dari URL (?inv_no=...) ──
      const params = new URLSearchParams(window.location.search);
      const invNo = params.get('inv_no');
      const data = dataFaktur[invNo];

      if (!data) {
        // Invoice tidak ditemukan / tidak dikirim lewat URL → sembunyikan form, tampilkan alert
        document.getElementById('alert-invoice-kosong').classList.remove('d-none');
        document.getElementById('card-pembeli').classList.add('d-none');
        document.getElementById('card-pesanan').classList.add('d-none');
        document.getElementById('card-bayar').classList.add('d-none');
        return;
      }

      // Simpan inv_no ke hidden input agar tetap terkirim saat submit
      document.getElementById('inputInvoiceHidden').value = invNo;

      // ── Isi Data Pembeli ──
      document.getElementById('info-nama').textContent = data.customer;
      document.getElementById('info-telepon').textContent = data.telepon;
      document.getElementById('info-alamat').textContent = data.alamat;

      // ── Isi Detail Pesanan ──
      document.getElementById('info-inv-no').textContent = invNo;

      const [label, color] = statusMap[data.status] || [data.status, 'secondary'];
      const badgeStatus = document.getElementById('info-status');
      badgeStatus.textContent = label;
      badgeStatus.className = `badge text-bg-${color}`;

      const tbody = document.getElementById('pesanan-body');
      tbody.innerHTML = '';
      let totalTagihan = 0;

      data.items.forEach((item) => {
        const sub = item.jumlah * item.harga;
        totalTagihan += sub;
        tbody.innerHTML += `
          <tr>
            <td>${item.nama}</td>
            <td class="text-end">${item.jumlah}</td>
            <td class="text-end">${fmt(item.harga)}</td>
            <td class="text-end">${fmt(sub)}</td>
          </tr>`;
      });

      document.getElementById('info-total-tagihan').textContent = fmt(totalTagihan);

      // ── Pre-fill nominal pembayaran dengan total tagihan ──
      document.getElementById('inputNominal').value = totalTagihan;

      // Tanggal pembayaran default hari ini
      document.getElementById('inputTanggalBayar').value = new Date().toISOString().split('T')[0];
    });
  </script>
</body>
</html>