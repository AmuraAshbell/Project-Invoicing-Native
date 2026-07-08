<head>
  <link rel="stylesheet" href="../../style/bar.css">
</head>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="/Invoicing-Native/dashboard.php" class="brand-link">
      <img src="/Invoicing-Native/dist/assets/img/AdminLTELogo.png"
           alt="AdminLTE Logo" class="brand-image opacity-75 shadow"/>
      <span class="brand-text fw-light">AdminLTE 4</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false" id="navigation">

        <li class="nav-item" data-child="dashboard">
          <a href="/Invoicing-Native/pages/beranda/dashboard.php" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Beranda</p>
          </a>
        </li>

        <li class="nav-item" data-group="transaksi">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-wallet2"></i>
            <p>
              Transaksi
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item" data-child="invoice">
              <a href="/Invoicing-Native/pages/invoice/table-invoice.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Faktur</p>
              </a>
            </li>
            <li class="nav-item" data-child="tunggakan">
              <a href="/Invoicing-Native/pages/tunggakan/tunggakan.php" class="nav-link">
                <i class="nav-icon bi bi-circle text-warning"></i>
                <p>Tunggakan</p>
              </a>
            </li>
            <li class="nav-item" data-child="pembayaran">
              <a href="/Invoicing-Native/pages/pembayaran/pembayaran.php" class="nav-link">
                <i class="nav-icon bi bi-circle text-success"></i>
                <p>Pembayaran</p>
              </a>
            </li>
            <li class="nav-item" data-child="laporan">
              <a href="/Invoicing-Native/pages/laporan/laporan.php" class="nav-link">
                <i class="nav-icon bi bi-circle text-info"></i>
                <p>Laporan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-group="master">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-database"></i>
            <p>
              Data Master
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item" data-child="barang">
              <a href="/Invoicing-Native/pages/barang/index.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Barang</p>
              </a>
            </li>
            <li class="nav-item" data-child="customer">
              <a href="/Invoicing-Native/pages/pelanggan/customer.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Pelanggan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-group="pengaturan">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-gear"></i>
            <p>
              Pengaturan
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item" data-child="perusahaan">
              <a href="/Invoicing-Native/pages/perusahaan/perusahaan.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Perusahaan</p>
              </a>
            </li>
            <li class="nav-item" data-child="manajemen">
              <a href="/Invoicing-Native/pages/Manajemen/user-manajemen.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Manajemen User</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>

<script>
  (function () {
    // Ambil nama file dari URL saat ini
    const page = location.pathname.split('/').pop().replace(/\.[^.]+$/, '') || 'dashboard';

    // 1. Array nama halaman (Tetap sama dengan milikmu)
    const dashboardPages  = ['dashboard'];
    const invoicePages    = ['table-invoice', 'edit-invoice', 'create-invoice', 'invoice'];
    const tunggakanPages  = ['tunggakan'];
    const pembayaranPages = ['pembayaran'];
    const laporanPages    = ['laporan'];
    
    const barangPages     = ['index', 'edit', 'create'];
    const customerPages   = ['customer', 'edit-customer', 'create-customer'];
    
    const perusahaanPages = ['perusahaan'];
    const manajemenPages  = ['user-manajemen'];

    // 2. Fungsi untuk menandai menu anak & membuka menu induk (Accordion)
    function setActive(pages, childId, parentGroupId) {
      if (pages.includes(page)) {
        // Tandai aktif pada menu bagian dalam (child)
        const childNode = document.querySelector(`[data-child="${childId}"]`);
        if (childNode) {
          childNode.querySelector('.nav-link').classList.add('active');
        }

        // Buka menu parent (Accordion) dan tandai aktif
        if (parentGroupId) {
          const groupNode = document.querySelector(`[data-group="${parentGroupId}"]`);
          if (groupNode) {
            groupNode.classList.add('menu-open');
            groupNode.querySelector(':scope > .nav-link').classList.add('active');
          }
        }
      }
    }

    // 3. Terapkan logika (Array Halaman, ID Child, ID Parent Grup)
    setActive(dashboardPages,  'dashboard',   null); // Beranda tidak punya parent
    
    // Group: TRANSAKSI
    setActive(invoicePages,    'invoice',     'transaksi');
    setActive(tunggakanPages,  'tunggakan',   'transaksi');
    setActive(pembayaranPages, 'pembayaran',  'transaksi');
    setActive(laporanPages,    'laporan',     'transaksi');
    
    // Group: DATA MASTER
    setActive(barangPages,     'barang',      'master');
    setActive(customerPages,   'customer',    'master');
    
    // Group: PENGATURAN
    setActive(perusahaanPages, 'perusahaan',  'pengaturan');
    setActive(manajemenPages,  'manajemen',   'pengaturan'); 
  })();
</script>