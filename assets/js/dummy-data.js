/**
 * dummy-data.js
 * ------------------------------------------------------------------
 * "Database palsu" terpusat untuk prototipe frontend Amura Store.
 * Semua halaman (Faktur, Pembayaran, Tunggakan) memakai sumber data
 * yang SAMA lewat localStorage, supaya begitu ada pembayaran baru
 * dicatat di satu halaman, halaman lain otomatis ikut berubah —
 * tanpa perlu database/backend sungguhan.
 *
 * Cara pakai (di halaman lain):
 *   <script src="../../assets/js/dummy-data.js"></script>
 *   const invoices = DummyDB.getInvoices();
 *   DummyDB.addPayment({ inv_no: 'INV-2026-001', nominal: 100000, ... });
 * ------------------------------------------------------------------
 */
(function (global) {
  "use strict";

  const KEY_INVOICES = "amura_invoices";
  const KEY_PAYMENTS = "amura_payments";
  const KEY_ITEMS = "amura_invoice_items"; // { [inv_no]: [ {nama, jumlah, harga}, ... ] }

  // ── Data awal (seed) — dipindahkan dari yang sebelumnya tercecer
  // di table-invoice.php, pembayaran.php, dan tunggakan.php ──
  const SEED_INVOICES = [
    {
      id: 1,
      inv_no: "INV-2026-001",
      customer: "Amelia Price",
      start_date: "2026-05-02",
      due_date: "2026-07-01",
      total: 650000,
      status_override: null,
    },
    {
      id: 2,
      inv_no: "INV-2026-002",
      customer: "Budi Santoso",
      start_date: "2026-05-02",
      due_date: "2026-07-05",
      total: 1560000,
      status_override: null,
    },
    {
      id: 3,
      inv_no: "INV-2026-003",
      customer: "Citra Dewi",
      start_date: "2026-05-02",
      due_date: "2026-07-10",
      total: 1200000,
      status_override: null,
    },
    {
      id: 4,
      inv_no: "INV-2026-004",
      customer: "Daniel Wijaya",
      start_date: "2026-05-02",
      due_date: "2026-07-12",
      total: 620000,
      status_override: "cancelled",
    },
    {
      id: 5,
      inv_no: "INV-2026-005",
      customer: "Eka Putri",
      start_date: "2026-05-02",
      due_date: "2026-07-15",
      total: 3950000,
      status_override: null,
    },
    {
      id: 6,
      inv_no: "INV-2026-006",
      customer: "Fahmi Malik",
      start_date: "2026-05-02",
      due_date: "2026-07-18",
      total: 1080000,
      status_override: null,
    },
    {
      id: 7,
      inv_no: "INV-2026-007",
      customer: "Gita Permata",
      start_date: "2026-05-02",
      due_date: "2026-07-20",
      total: 1450000,
      status_override: null,
    },
    {
      id: 8,
      inv_no: "INV-2026-008",
      customer: "Hendra Wijaya",
      start_date: "2026-05-02",
      due_date: "2026-07-22",
      total: 1160000,
      status_override: null,
    },
    {
      id: 9,
      inv_no: "INV-2026-009",
      customer: "Indah Lestari",
      start_date: "2026-05-02",
      due_date: "2026-07-25",
      total: 1100000,
      status_override: null,
    },
    {
      id: 10,
      inv_no: "INV-2026-010",
      customer: "Joko Anwar",
      start_date: "2026-05-02",
      due_date: "2026-07-28",
      total: 680000,
      status_override: "cancelled",
    },
  ];

  // Riwayat pembayaran awal (disamakan dengan yang tadinya di pembayaran.php & tunggakan.php)
  const SEED_PAYMENTS = [
    {
      id: 1,
      inv_no: "INV-2026-001",
      tanggal: "2026-06-23",
      nominal: 650000,
      metode: "Tunai",
      referensi: "",
      catatan: "",
    },
    {
      id: 2,
      inv_no: "INV-2026-002",
      tanggal: "2026-06-24",
      nominal: 800000,
      metode: "Transfer Bank",
      referensi: "",
      catatan: "",
    },
    {
      id: 3,
      inv_no: "INV-2026-003",
      tanggal: "2026-06-25",
      nominal: 1200000,
      metode: "QRIS",
      referensi: "",
      catatan: "",
    },
    {
      id: 4,
      inv_no: "INV-2026-005",
      tanggal: "2026-06-27",
      nominal: 3950000,
      metode: "Transfer Bank",
      referensi: "",
      catatan: "",
    },
    {
      id: 5,
      inv_no: "INV-2026-006",
      tanggal: "2026-06-28",
      nominal: 500000,
      metode: "Tunai",
      referensi: "",
      catatan: "",
    },
    {
      id: 6,
      inv_no: "INV-2026-007",
      tanggal: "2026-06-29",
      nominal: 1450000,
      metode: "Kartu Debit",
      referensi: "",
      catatan: "",
    },
    {
      id: 7,
      inv_no: "INV-2026-008",
      tanggal: "2026-06-30",
      nominal: 300000,
      metode: "Tunai",
      referensi: "",
      catatan: "",
    },
    {
      id: 8,
      inv_no: "INV-2026-009",
      tanggal: "2026-07-01",
      nominal: 1100000,
      metode: "QRIS",
      referensi: "",
      catatan: "",
    },
  ];

  // ── Helper baca/tulis localStorage ──
  function readJSON(key, fallback) {
    try {
      const raw = localStorage.getItem(key);
      if (!raw) return fallback;
      return JSON.parse(raw);
    } catch (e) {
      return fallback;
    }
  }

  function writeJSON(key, value) {
    localStorage.setItem(key, JSON.stringify(value));
  }

  function ensureSeeded() {
    if (!localStorage.getItem(KEY_INVOICES))
      writeJSON(KEY_INVOICES, SEED_INVOICES);
    if (!localStorage.getItem(KEY_PAYMENTS))
      writeJSON(KEY_PAYMENTS, SEED_PAYMENTS);
  }

  ensureSeeded();

  // ── Format mata uang ──
  function fmt(n) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(n || 0);
  }

  // ── Invoice ──
  function getRawInvoices() {
    return readJSON(KEY_INVOICES, SEED_INVOICES);
  }

  function getRawPayments() {
    return readJSON(KEY_PAYMENTS, SEED_PAYMENTS);
  }

  // Hitung status otomatis: cancelled (override manual) > paid > partial > unpaid
  function computeStatus(invoice, totalTerbayar) {
    if (invoice.status_override === "cancelled") return "cancelled";
    if (totalTerbayar <= 0) return "unpaid";
    if (totalTerbayar >= invoice.total) return "paid";
    return "partial";
  }

  // Ambil semua invoice, sudah dilengkapi terbayar/sisa/status (dihitung real-time dari payments)
  function getInvoices() {
    const invoices = getRawInvoices();
    const payments = getRawPayments();

    return invoices.map((inv) => {
      const totalTerbayar = payments
        .filter((p) => p.inv_no === inv.inv_no)
        .reduce((sum, p) => sum + Number(p.nominal || 0), 0);

      const sisa = Math.max(inv.total - totalTerbayar, 0);
      const status = computeStatus(inv, totalTerbayar);

      return Object.assign({}, inv, {
        price: inv.total, // alias, dipakai tabel lama (table-invoice.php)
        terbayar: totalTerbayar,
        sisa,
        status,
      });
    });
  }

  function getInvoiceByNo(invNo) {
    return getInvoices().find((inv) => inv.inv_no === invNo) || null;
  }

  function invoiceExists(invNo) {
    return getRawInvoices().some((inv) => inv.inv_no === invNo);
  }

  // Bikin nomor faktur otomatis format "INV-####" (4 digit acak),
  // dicek berulang supaya dijamin tidak bentrok dengan faktur yang sudah ada.
  function generateInvoiceNumber() {
    const existing = new Set(getRawInvoices().map((inv) => inv.inv_no));
    let invNo;
    let attempt = 0;

    do {
      const rand = Math.floor(1000 + Math.random() * 9000); // 1000–9999
      invNo = `INV-${rand}`;
      attempt++;
    } while (existing.has(invNo) && attempt < 200);

    return invNo;
  }

  // Daftarkan/​sinkronkan faktur ke DB.
  // - Faktur baru (belum ada) -> langsung dibuat, ditandai `editable_total`
  //   supaya totalnya boleh ikut menyesuaikan selama barang masih ditambah/diubah.
  // - Faktur lama/seed (sudah ada & bukan hasil buatan sendiri) -> TIDAK
  //   ditimpa totalnya, supaya data invoice lama & histori pembayarannya
  //   tidak berubah setiap kali halaman detail cuma dibuka.
  function upsertInvoice(data) {
    const invoices = getRawInvoices();
    const idx = invoices.findIndex((inv) => inv.inv_no === data.inv_no);

    if (idx === -1) {
      const nextId = invoices.length
        ? Math.max(...invoices.map((i) => i.id)) + 1
        : 1;
      invoices.push(
        Object.assign(
          {
            id: nextId,
            customer: "Pelanggan Belum Diisi",
            start_date: new Date().toISOString().slice(0, 10),
            status_override: null,
            editable_total: true,
          },
          data,
        ),
      );
      writeJSON(KEY_INVOICES, invoices);
      return;
    }

    if (invoices[idx].editable_total) {
      invoices[idx] = Object.assign({}, invoices[idx], {
        customer: data.customer || invoices[idx].customer,
        due_date: data.due_date || invoices[idx].due_date,
        total: data.total,
      });
      writeJSON(KEY_INVOICES, invoices);
    }
  }

  // ── Barang per faktur ──
  // Sebelumnya daftar barang di halaman detail faktur cuma hidup di memori
  // browser (reset ke kosong tiap halaman dibuka lagi). Ini bikin total
  // faktur ikut ke-reset ke Rp0 setiap kali faktur dibuka ulang, yang pada
  // gilirannya bikin status pembayaran salah hitung (faktur yang baru
  // dibayar sebagian bisa kelihatan "Lunas" begitu halaman dibuka lagi).
  // Sekarang barang disimpan per nomor faktur, supaya totalnya konsisten.
  function getAllItemsMap() {
    return readJSON(KEY_ITEMS, {});
  }

  function getItems(invNo) {
    const map = getAllItemsMap();
    return Array.isArray(map[invNo]) ? map[invNo] : [];
  }

  function saveItems(invNo, items) {
    const map = getAllItemsMap();
    map[invNo] = items;
    writeJSON(KEY_ITEMS, map);
  }

  // ── Pembayaran ──
  function getPayments(invNo) {
    const payments = getRawPayments();
    if (!invNo) return payments;
    return payments.filter((p) => p.inv_no === invNo);
  }

  // Tambah pembayaran baru → otomatis dapat id baru & tersimpan
  function addPayment(payment) {
    const payments = getRawPayments();
    const nextId = payments.length
      ? Math.max(...payments.map((p) => p.id)) + 1
      : 1;

    const record = Object.assign(
      {
        id: nextId,
        tanggal: new Date().toISOString().slice(0, 10),
        metode: "Tunai",
        referensi: "",
        catatan: "",
      },
      payment,
      { id: nextId },
    );

    payments.push(record);
    writeJSON(KEY_PAYMENTS, payments);
    return record;
  }

  function deletePayment(paymentId) {
    const payments = getRawPayments().filter((p) => p.id !== paymentId);
    writeJSON(KEY_PAYMENTS, payments);
  }

  // ── Rekap Tunggakan per pelanggan (dipakai tunggakan.php) ──
  // Ikut menyertakan daftar faktur per pelanggan (field `faktur`) supaya
  // halaman Tunggakan bisa link langsung ke faktur yang jadi penyebab
  // tunggakan tersebut — bukan cuma angka agregat tanpa sumber.
  function getTunggakanPerPelanggan() {
    const invoices = getInvoices();
    const map = {};

    invoices.forEach((inv) => {
      if (inv.status === "cancelled") return; // faktur batal tidak dihitung sbg tunggakan
      if (!map[inv.customer]) {
        map[inv.customer] = {
          nama: inv.customer,
          total_inv: 0,
          terbayar: 0,
          faktur: [],
        };
      }
      map[inv.customer].total_inv += inv.total;
      map[inv.customer].terbayar += inv.terbayar;
      map[inv.customer].faktur.push({
        inv_no: inv.inv_no,
        total: inv.total,
        sisa: inv.sisa,
        status: inv.status,
      });
    });

    return Object.values(map);
  }

  // ── Reset ke data awal (berguna untuk demo ulang) ──
  function reset() {
    writeJSON(KEY_INVOICES, SEED_INVOICES);
    writeJSON(KEY_PAYMENTS, SEED_PAYMENTS);
  }

  // ── Toast notifikasi generik (dipakai di semua halaman) ──
  // Membuat container toast otomatis kalau belum ada di halaman.
  function ensureToastContainer() {
    let container = document.getElementById("dummydb-toast-container");
    if (!container) {
      container = document.createElement("div");
      container.id = "dummydb-toast-container";
      container.className = "toast-container position-fixed top-0 end-0 p-4";
      container.style.zIndex = 1080;
      document.body.appendChild(container);
    }
    return container;
  }

  function showToast(message, type) {
    type = type === "error" ? "error" : "success";
    const icon =
      type === "success"
        ? "bi-check-circle-fill"
        : "bi-exclamation-triangle-fill";
    const bg = type === "success" ? "text-bg-success" : "text-bg-danger";

    const container = ensureToastContainer();
    const toastEl = document.createElement("div");
    toastEl.className = `toast align-items-center ${bg} border-0`;
    toastEl.setAttribute("role", "alert");
    toastEl.innerHTML = `
      <div class="d-flex">
        <div class="toast-body fw-medium"><i class="bi ${icon} me-2"></i>${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>`;
    container.appendChild(toastEl);

    const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
    toast.show();
    toastEl.addEventListener("hidden.bs.toast", () => toastEl.remove());
  }

  global.DummyDB = {
    fmt,
    getInvoices,
    getInvoiceByNo,
    invoiceExists,
    generateInvoiceNumber,
    upsertInvoice,
    getItems,
    saveItems,
    getPayments,
    addPayment,
    deletePayment,
    getTunggakanPerPelanggan,
    reset,
    showToast,
  };
})(window);
