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
      <ul class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="navigation"
          aria-label="Main navigation"
          data-accordion="true"
          id="navigation">

        <li class="nav-item" data-page="dashboard">
          <a href="/Invoicing-Native/pages/beranda/dashboard.php" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Beranda</p>
          </a>
        </li>

        <li class="nav-header">DATA</li>

        <li class="nav-item" data-group="barang">
          <a href="/Invoicing-Native/pages/barang/index.php" class="nav-link">
            <i class="nav-icon bi bi-box-seam-fill"></i>
            <p>Barang</p>
          </a>
        </li>

        <li class="nav-item" data-group="customer">
          <a href="/Invoicing-Native/pages/pelanggan/customer.php" class="nav-link">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Pelanggan</p>
          </a>
        </li>

        <li class="nav-item" data-group="invoice">
          <a href="/Invoicing-Native/pages/invoice/table-invoice.php" class="nav-link">
            <i class="nav-icon bi bi-receipt"></i>
            <p>Faktur</p>
          </a>
        </li>

        <li class="nav-item" data-group="laporan">
          <a href="/Invoicing-Native/pages/laporan/laporan.php" class="nav-link">
            <i class="nav-icon bi bi-bar-chart-fill"></i>
            <p>Laporan</p>
          </a>
        </li>

        <li class="nav-item" data-group="pembayaran">
          <a href="/Invoicing-Native/pages/pembayaran/pembayaran.php" class="nav-link">
            <i class="nav-icon bi bi-bar-chart-fill"></i>
            <p>Pembayaran</p>
          </a>
        </li>
        <li class="nav-item" data-group="tunggakan">
          <a href="/Invoicing-Native/pages/tunggakan/tunggakan.php" class="nav-link">
            <i class="nav-icon bi bi-bar-chart-fill"></i>
            <p>Tunggakan</p>
          </a>
        </li>
        <li class="nav-item" data-group="perusahaan">
          <a href="/Invoicing-Native/pages/perusahaan/perusahaan.php" class="nav-link">
            <i class="nav-icon bi bi-building"></i>
            <p>Perusahaan</p>
          </a>
        </li>
        <li class="nav-item" data-group="Manajemen">
          <a href="/Invoicing-Native/pages/Manajemen/user-manajemen.php" class="nav-link">
            <i class="nav-icon bi bi-gear"></i>
            <p>Manajemen User</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<script>
  (function () {
    const page = location.pathname.split('/').pop().replace(/\.[^.]+$/, '') || 'dashboard';

    const barangPages     = ['index', 'edit', 'create'];
    const customerPages   = ['customer', 'edit-customer', 'create-customer'];
    const invoicePages    = ['table-invoice', 'edit-invoice', 'create-invoice', 'invoice'];
    const laporanPages    = ['laporan'];
    const pembayaranPages = ['pembayaran'];
    const tunggakanPages  = ['tunggakan'];
    const perusahaanPages = ['perusahaan'];
    const manajemenPages  = ['user-manajemen'];

    document.querySelectorAll('[data-page]').forEach(li => {
      if (li.dataset.page === page) {
        li.querySelector('.nav-link').classList.add('active');
      }
    });

    function openGroup(pages, groupName) {
      if (pages.includes(page)) {
        const group = document.querySelector(`[data-group="${groupName}"]`);
        if (group) {
          group.classList.add('menu-open');
          group.querySelector(':scope > .nav-link').classList.add('active');
        }
      }
    }

    openGroup(barangPages,   'barang');
    openGroup(customerPages, 'customer');
    openGroup(invoicePages,  'invoice');
    openGroup(laporanPages,  'laporan');
    openGroup(pembayaranPages, 'pembayaran');
    openGroup(tunggakanPages, 'tunggakan');
    openGroup(perusahaanPages, 'perusahaan');
    openGroup(manajemenPages, 'Manajemen'); 
  })();
</script>
