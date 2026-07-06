<?php
// 1. Panggil autoload composer
require_once __DIR__ . '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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
                    <div class="kwitansi-no">No. KWT-2026-042</div>
                </td>
            </tr>
        </table>
        
        <div class="border-bottom"></div>

        <!-- Bagian Isi -->
        <table>
            <tr class="row-item">
                <td class="label">Telah terima dari</td>
                <td class="value">Bapak Zidan Rasyid</td>
            </tr>
            <tr class="row-item">
                <td class="label">Uang sejumlah</td>
                <td class="value bg-light-value"># Enam Ratus Lima Puluh Ribu Rupiah #</td>
            </tr>
            <tr class="row-item">
                <td class="label">Untuk pembayaran</td>
                <td class="value">Pelunasan Invoice No. INV-2026-00428 (Pembelian RG 1/144 RX-93 v Gundam)</td>
            </tr>
        </table>

        <!-- Bagian Footer (Nominal & TTD) -->
        <table class="footer-table">
            <tr>
                <td style="width: 50%; vertical-align: bottom;">
                    <div class="box-nominal">
                        Rp 650.000,-
                    </div>
                </td>
                <td style="width: 50%;" class="signature-area">
                    <div>Surabaya, 02 Juli 2026</div>
                    <div class="signature-name">Amelia Price</div>
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
$dompdf->stream("Kwitansi_INV-2026-00428.pdf", array("Attachment" => 0));
?>