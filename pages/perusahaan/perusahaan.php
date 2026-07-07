<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Perusahaan</title>
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css"/>
</head>
<body class="app-wrapper">
    <?php include "../../layout/navbar.php"; ?>
    <?php include "../../layout/sidebar.php"; ?>

    <main class="app-main">
        <!-- ── Header Konten ── -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Informasi Perusahaan</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="../../dashboard.php">Beranda</a></li>
                            <li class="breadcrumb-item active">Perusahaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Isi Konten ── -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">

                    <!-- ── Kolom Kiri ── -->
                    <div class="col-lg-7">

                        <!-- Card Tampilan Informasi Perusahaan -->
                        <div class="card mb-4 mx-auto" style="margin: 0 auto;">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">Informasi Perusahaan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Nama Perusahaan</p>
                                        <p class="mb-0 fw-semibold" id="view-nama">Amura Store</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Badan Usaha</p>
                                        <p class="mb-0 fw-semibold" id="view-badan">Perorangan</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Bidang Bisnis</p>
                                        <p class="mb-0 fw-semibold" id="view-bisnis">Retail & Perdagangan</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Website Bisnis</p>
                                        <p class="mb-0 fw-semibold" id="view-website">-</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small mb-1">Deskripsi Usaha</p>
                                        <p class="mb-0" id="view-deskripsi">Toko penjualan gunpla dan merchandise anime.</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Provinsi</p>
                                        <p class="mb-0 fw-semibold" id="view-provinsi">Jawa Timur</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Kota/Kabupaten</p>
                                        <p class="mb-0 fw-semibold" id="view-kota">Kota Surabaya</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Kecamatan</p>
                                        <p class="mb-0 fw-semibold" id="view-kecamatan">Sukomanunggal</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-secondary small mb-1">Negara</p>
                                        <p class="mb-0 fw-semibold">Indonesia</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-secondary small mb-1">Alamat Perusahaan</p>
                                        <p class="mb-0 fw-semibold" id="view-alamat">Jl. Simo Pomahan, Surabaya</p>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 d-flex justify-content-end">
                                    <button class="btn btn-md btn-warning" onclick="bukaModal('modalEditPerusahaan')">
                                        <i class="bi bi-pencil-square me-1"></i>Ubah
                                    </button> 
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ── Kolom Kanan ── -->
                    <div class="col-lg-5">

                        <!-- Card Informasi Kontak -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Informasi Kontak Perusahaan</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <p class="text-secondary small mb-1">Email Perusahaan</p>
                                    <p class="mb-0 fw-semibold" id="view-email">zidanrasyidsusanto19@gmail.com</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-secondary small mb-1">No. Telepon / WhatsApp</p>
                                    <p class="mb-0 fw-semibold" id="view-telepon">+62 852 1952 6186</p>
                                </div>
                                
                                <div class="d-flex justify-content-end pt-2">
                                    <button class="btn btn-sm btn-warning" onclick="bukaModal('modalEditKontak')">
                                        <i class="bi bi-pencil-square me-1"></i> Ubah Kontak
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Card Branding Dokumen (Sesuai Gambar) -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Branding Dokumen</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Kotak Upload Logo -->
                                    <div class="col-6">
                                        <p class="text-secondary small mb-2 text-center">Logo Perusahaan</p>
                                        <label for="inputLogo" class="border border-2 rounded text-center p-3 d-flex flex-column align-items-center justify-content-center w-100" style="cursor: pointer; border-style: dashed !important; border-color: #6c757d !important; background: rgba(0,0,0,0.02); min-height: 130px;">
                                            <div id="preview-logo-content" class="w-100 text-center">
                                                <i class="bi bi-cloud-arrow-up fs-2 text-secondary mb-2 d-block"></i>
                                                <span class="small text-muted d-block text-truncate">Pilih Logo (1:1)</span>
                                            </div>
                                            <input type="file" id="inputLogo" accept="image/*" class="d-none">
                                        </label>
                                    </div>
                                    
                                    <!-- Kotak Upload TTD -->
                                    <div class="col-6">
                                        <p class="text-secondary small mb-2 text-center">Tanda Tangan</p>
                                        <label for="inputTTD" class="border border-2 rounded text-center p-3 d-flex flex-column align-items-center justify-content-center w-100" style="cursor: pointer; border-style: dashed !important; border-color: #6c757d !important; background: rgba(0,0,0,0.02); min-height: 130px;">
                                            <div id="preview-ttd-content" class="w-100 text-center">
                                                <i class="bi bi-pen fs-2 text-secondary mb-2 d-block"></i>
                                                <span class="small text-muted d-block text-truncate">Pilih TTD (PNG)</span>
                                            </div>
                                            <input type="file" id="inputTTD" accept="image/png" class="d-none">
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <small class="text-muted" style="font-size: 0.75rem;">Format disarankan: PNG transparan. Maks 2MB.</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ── Modal Edit Perusahaan ── -->
    <div class="modal fade" id="modalEditPerusahaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Informasi Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Nama Perusahaan*</label>
                            <input type="text" class="form-control" id="edit-nama" value="Amura Store">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Badan Usaha*</label>
                            <select class="form-select" id="edit-badan">
                                <option selected>Perorangan</option>
                                <option>CV</option>
                                <option>PT</option>
                                <option>UD</option>
                                <option>Firma</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Bidang Bisnis*</label>
                            <input type="text" class="form-control" id="edit-bisnis" value="Retail & Perdagangan">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Website Bisnis <span class="text-secondary">(opsional)</span></label>
                            <input type="url" class="form-control" id="edit-website" placeholder="https://...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Usaha*</label>
                            <textarea class="form-control" id="edit-deskripsi" rows="2">Toko penjualan gunpla dan merchandise anime.</textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Provinsi*</label>
                            <input type="text" class="form-control" id="edit-provinsi" value="Jawa Timur">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Kota/Kabupaten*</label>
                            <input type="text" class="form-control" id="edit-kota" value="Kota Surabaya">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Kecamatan*</label>
                            <input type="text" class="form-control" id="edit-kecamatan" value="Sukomanunggal">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Perusahaan*</label>
                            <textarea class="form-control" id="edit-alamat" rows="2">Jl. Simo Pomahan, Surabaya</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanPerusahaan">
                        <i class="bi bi-check-lg me-1"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Modal Edit Kontak ── -->
    <div class="modal fade" id="modalEditKontak" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Kontak Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email Perusahaan*</label>
                        <input type="email" class="form-control" id="edit-email" value="zidanrasyidsusanto19@gmail.com">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">No. Telepon / WhatsApp* </label>
                        <input type="tel" class="form-control" id="edit-telepon" value="+62 852 1952 6186">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanKontak">
                        <i class="bi bi-check-lg me-1"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Modal Edit Lainnya (NPWP & Bank) ── -->
    <div class="modal fade" id="modalEditLainnya" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Informasi Lainnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="edit-npwp" placeholder="xx.xxx.xxx.x-xxx.xxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Rekening Bank</label>
                        <input type="text" class="form-control" id="edit-rekening" placeholder="Nomor rekening">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Nama Bank</label>
                        <select class="form-select" id="edit-bank">
                            <option value="">-- Pilih Bank --</option>
                            <option>BCA</option>
                            <option>BRI</option>
                            <option>BNI</option>
                            <option>Mandiri</option>
                            <option>BSI</option>
                            <option>CIMB Niaga</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanLainnya">
                        <i class="bi bi-check-lg me-1"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../../layout/footer.php"; ?>

    <!-- ── Scripts ── -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/adminlte.js"></script>
    
    <!-- Script Tema -->
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
      })();
    </script>

    <!-- Script Fungsionalitas Halaman -->
    <script>
      // Buka Modal
      function bukaModal(id) {
        new bootstrap.Modal(document.getElementById(id)).show();
      }

      // ── Simpan Informasi Perusahaan ──
      document.getElementById('btnSimpanPerusahaan').addEventListener('click', () => {
        document.getElementById('view-nama').textContent      = document.getElementById('edit-nama').value || '-';
        document.getElementById('view-badan').textContent     = document.getElementById('edit-badan').value || '-';
        document.getElementById('view-bisnis').textContent    = document.getElementById('edit-bisnis').value || '-';
        document.getElementById('view-website').textContent   = document.getElementById('edit-website').value || '-';
        document.getElementById('view-deskripsi').textContent = document.getElementById('edit-deskripsi').value || '-';
        document.getElementById('view-provinsi').textContent  = document.getElementById('edit-provinsi').value || '-';
        document.getElementById('view-kota').textContent      = document.getElementById('edit-kota').value || '-';
        document.getElementById('view-kecamatan').textContent = document.getElementById('edit-kecamatan').value || '-';
        document.getElementById('view-alamat').textContent    = document.getElementById('edit-alamat').value || '-';
        bootstrap.Modal.getInstance(document.getElementById('modalEditPerusahaan')).hide();
      });

      // ── Simpan Kontak ──
      document.getElementById('btnSimpanKontak').addEventListener('click', () => {
        document.getElementById('view-email').textContent   = document.getElementById('edit-email').value || '-';
        document.getElementById('view-telepon').textContent = document.getElementById('edit-telepon').value || '-';
        bootstrap.Modal.getInstance(document.getElementById('modalEditKontak')).hide();
      });

      // ── Simpan Lainnya ──
      document.getElementById('btnSimpanLainnya').addEventListener('click', () => {
        document.getElementById('view-npwp').textContent     = document.getElementById('edit-npwp').value || '-';
        document.getElementById('view-rekening').textContent = document.getElementById('edit-rekening').value || '-';
        document.getElementById('view-bank').textContent     = document.getElementById('edit-bank').value || '-';
        bootstrap.Modal.getInstance(document.getElementById('modalEditLainnya')).hide();
      });

      // ── Preview logo dalam kotak putus-putus ──
      document.getElementById('inputLogo').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
          const previewContent = document.getElementById('preview-logo-content');
          previewContent.innerHTML = `
            <img src="${ev.target.result}" class="img-fluid rounded mb-2" style="max-height: 65px; object-fit: contain;">
            <span class="small text-primary d-block fw-bold text-truncate w-100 px-2">${file.name}</span>
          `;
        };
        reader.readAsDataURL(file);
      });

      // ── Preview TTD dalam kotak putus-putus ──
      document.getElementById('inputTTD').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
          const previewContent = document.getElementById('preview-ttd-content');
          previewContent.innerHTML = `
            <img src="${ev.target.result}" class="img-fluid rounded mb-2" style="max-height: 65px; object-fit: contain;">
            <span class="small text-primary d-block fw-bold text-truncate w-100 px-2">${file.name}</span>
          `;
        };
        reader.readAsDataURL(file);
      });
    </script>
</body>
</html>