<?php
// 1. Panggil autoload composer
require_once __DIR__ . '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ── Data pembayaran: diambil dari parameter GET yang dikirim otomatis
// oleh modal "Bayar Sekarang" di invoice.php. Kalau dibuka langsung
// tanpa parameter (mis. saat testing), pakai contoh data sebagai default. ──
$inv_no    = $_GET['inv_no']    ?? 'INV-2026-00428';
$customer  = $_GET['customer']  ?? 'Bapak Zidan Rasyid';
$nominal   = isset($_GET['nominal']) ? (int) $_GET['nominal'] : 650000;
$tanggal   = $_GET['tanggal']   ?? date('Y-m-d');
$metode    = $_GET['metode']    ?? 'Tunai';
$kwitansiNo = 'KWT-' . date('Y') . '-' . str_pad((string) (crc32($inv_no) % 999), 3, '0', STR_PAD_LEFT);

function tanggalIndonesia($tgl) {
    $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
              '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $parts = explode('-', $tgl);
    if (count($parts) !== 3) return $tgl;
    [$y, $m, $d] = $parts;
    return ((int) $d) . ' ' . ($bulan[$m] ?? $m) . ' ' . $y;
}

// ── Terbilang: ubah angka nominal jadi teks "Enam Ratus Lima Puluh Ribu Rupiah" ──
function terbilang($angka) {
    $angka = (int) abs($angka);
    $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
              'Sebelas'];

    if ($angka < 12) return $huruf[$angka];
    if ($angka < 20) return terbilang($angka - 10) . ' Belas';
    if ($angka < 100) return trim(terbilang((int) ($angka / 10)) . ' Puluh ' . terbilang($angka % 10));
    if ($angka < 200) return trim('Seratus ' . terbilang($angka - 100));
    if ($angka < 1000) return trim(terbilang((int) ($angka / 100)) . ' Ratus ' . terbilang($angka % 100));
    if ($angka < 2000) return trim('Seribu ' . terbilang($angka - 1000));
    if ($angka < 1000000) return trim(terbilang((int) ($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000));
    if ($angka < 1000000000) return trim(terbilang((int) ($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000));
    return trim(terbilang((int) ($angka / 1000000000)) . ' Miliar ' . terbilang($angka % 1000000000));
}

$nominalTerbilang = trim(terbilang($nominal)) . ' Rupiah';

// 2. Setup Options DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);

// 3. Desain HTML Kwitansi (Menggunakan Table agar aman di DOMPDF)
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Kwitansi</title>
    <style>
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            color: #333;
        }
        .kwitansi-wrapper {
            border: 2px solid #2c3e50;
            padding: 40px;
            margin: 20px auto;
            position: relative;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /* Header */
        .header-title {
            color: #0d6efd;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header-subtitle {
            font-size: 12px;
            color: #6c757d;
        }
        .kwitansi-text {
            font-size: 32px;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-align: right;
        }
        .kwitansi-no {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        /* Border Header */
        .border-bottom {
            border-bottom: 2px solid #333;
            margin-top: 15px;
            margin-bottom: 30px;
        }
        /* Isi Kwitansi */
        .row-item td {
            padding: 15px 0;
            vertical-align: bottom;
            font-size: 16px;
        }
        .label {
            width: 25%;
            font-weight: bold;
        }
        .value {
            border-bottom: 1px dotted #000;
            width: 75%;
            font-style: italic;
            padding-left: 10px;
        }
        .bg-light-value {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        /* Footer */
        .footer-table {
            margin-top: 50px;
        }
        .box-nominal {
            background-color: #f8f9fa;
            border: 2px solid #2c3e50;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            width: 250px;
            color: #0d6efd;
        }
        .signature-area {
            text-align: center;
            font-size: 14px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <div class="kwitansi-wrapper">
        
        <!-- Bagian Header -->
        <table>
            <tr>
                <td style="width: 60%;">
                    <div class="header-title">Gundam Store Nusantara</div>
                    <div class="header-subtitle">Jl. Tunjungan No. 1, Surabaya | Telp: 0812-3456-7890</div>
                </td>
                <td style="width: 40%;">
                    <div class="kwitansi-text">Kwitansi</div>
                    <div class="kwitansi-no">No. ' . htmlspecialchars($kwitansiNo) . '</div>
                </td>
            </tr>
        </table>
        
        <div class="border-bottom"></div>

        <!-- Bagian Isi -->
        <table>
            <tr class="row-item">
                <td class="label">Telah terima dari</td>
                <td class="value">' . htmlspecialchars($customer) . '</td>
            </tr>
            <tr class="row-item">
                <td class="label">Uang sejumlah</td>
                <td class="value bg-light-value"># ' . htmlspecialchars($nominalTerbilang) . ' #</td>
            </tr>
            <tr class="row-item">
                <td class="label">Untuk pembayaran</td>
                <td class="value">Pelunasan Invoice No. ' . htmlspecialchars($inv_no) . ' (' . htmlspecialchars($metode) . ')</td>
            </tr>
        </table>

        <!-- Bagian Footer (Nominal & TTD) -->
        <table class="footer-table">
            <tr>
                <td style="width: 50%; vertical-align: bottom;">
                    <div class="box-nominal">
                        Rp ' . number_format($nominal, 0, ',', '.') . ',-
                    </div>
                </td>
                <td style="width: 50%;" class="signature-area">
                    <div>Surabaya, ' . htmlspecialchars(tanggalIndonesia($tanggal)) . '</div>
                    <div class="signature-name">' . htmlspecialchars($customer) . '</div>
                    <div style="color: #6c757d;">Finance & Cashier</div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
';

// 4. Masukkan HTML ke DOMPDF
$dompdf->loadHtml($html);

// 5. Atur Ukuran Kertas (A4, orientasi Landscape agar cocok untuk kwitansi)
$dompdf->setPaper('A4', 'landscape');

// 6. Render
$dompdf->render();

// 7. Output PDF
// Ubah "Attachment" => 1 jika ingin langsung otomatis terdownload
$dompdf->stream("Kwitansi_" . $inv_no . ".pdf", array("Attachment" => 0));
?>