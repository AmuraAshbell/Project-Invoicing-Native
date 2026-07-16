<?php
require '../../vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['inv_no'])) {
    $inv_no = $_GET['inv_no'];
    $action = isset($_GET['action']) ? $_GET['action'] : 'download';

    // 1. Data Dummy (Nanti ganti dengan data dari query database)
    $tanggal = "13 Juli 2026";
    $jatuh_tempo = "20 Juli 2026";
    $nama_pelanggan = "Budi Santoso";

    // Pastikan path dan ekstensi file (misal .png) benar sesuai file Anda
    $path_logo = __DIR__ . '/../../assets/logo-hitam.png'; 
    $base64_logo = '';
    
    if (file_exists($path_logo)) {
        $type_logo = pathinfo($path_logo, PATHINFO_EXTENSION);
        $data_logo = file_get_contents($path_logo);
        $base64_logo = 'data:image/' . $type_logo . ';base64,' . base64_encode($data_logo);
    }
    
    // 2. Desain HTML Khusus DomPDF yang menyamai Pict 1
    $html = '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Invoice ' . $inv_no . '</title>
        <style>
            /* Reset & Typography dasar */
            body { 
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; 
                font-size: 13px; 
                color: #333; 
            }
            .text-primary { color: #0d6efd; }
            .text-muted { color: #6c757d; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .mb-0 { margin-bottom: 0; }
            
            /* Struktur Tabel Utama untuk Grid (Kiri-Kanan) */
            table.grid-table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-bottom: 20px; 
            }
            table.grid-table td { 
                vertical-align: top; 
                border: none;
            }

            /* Judul Bagian */
            .section-title { 
                font-size: 11px; 
                font-weight: bold; 
                color: #6c757d; 
                margin-bottom: 5px; 
                letter-spacing: 1px;
            }
            
            /* Tabel Daftar Barang */
            table.items-table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-bottom: 20px;
            }
            table.items-table th { 
                background-color: #f8f9fa; 
                border-bottom: 2px solid #dee2e6; 
                padding: 10px; 
                text-align: left; 
            }
            table.items-table td { 
                border-bottom: 1px solid #dee2e6; 
                padding: 10px; 
            }
            table.items-table th.text-right, 
            table.items-table td.text-right { text-align: right; }
            table.items-table th.text-center, 
            table.items-table td.text-center { text-align: center; }
            
            /* Area Total (Ditarik ke Kanan) */
            .total-box {
                width: 45%;
                float: right;
            }
            .total-box table { width: 100%; border-collapse: collapse; }
            .total-box td { padding: 6px 0; border: none; }
            .total-box .grand-total { 
                font-size: 16px; 
                font-weight: bold; 
                color: #0d6efd; 
                border-top: 2px solid #dee2e6;
                padding-top: 10px;
                margin-top: 5px;
            }

            /* Kotak Catatan */
            .note-box {
                background-color: #f8f9fa;
                border-left: 4px solid #0d6efd;
                padding: 12px 15px;
                margin-top: 40px;
            }
        </style>
    </head>
    <body>

        <table class="grid-table" style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
    <tr>
        <td style="width: 50%; vertical-align: middle; border: none;">
            <img src="' . $base64_logo . '" alt="Logo Amura Store" style="max-height: 100px; width: auto; margin-left: -15px;">
            
            <p class="text-muted" style="margin: 0; line-height: 1.5;">
                Jl. Rungkut Madya No. 123<br>
                Surabaya, Jawa Timur 60293<br>
                Email: halo@amurastore.com<br>
                Telp: 0812-3456-7890
            </p>
        </td>
        <td style="width: 50%; text-align: right; vertical-align: middle; border: none;">
            <h1 style="margin: 0 0 10px 0; color: #495057; font-size: 32px; letter-spacing: 2px;">INVOICE</h1>
            <p style="margin: 0; line-height: 1.6;">
                <strong>No. Faktur:</strong> ' . $inv_no . '<br>
                <strong>Tanggal:</strong> ' . $tanggal . '<br>
                <strong>Jatuh Tempo:</strong> ' . $jatuh_tempo . '
            </p>
        </td>
    </tr>
</table>

        <hr style="border: 0; border-top: 1px solid #dee2e6; margin-bottom: 25px;">

        <table class="grid-table">
            <tr>
                <td width="50%">
                    <div class="section-title">DITAGIHKAN KEPADA:</div>
                    <h3 style="margin: 0 0 5px 0; font-size: 16px;">' . $nama_pelanggan . '</h3>
                    <p class="text-muted" style="margin: 0; line-height: 1.5;">
                        Jl. Mawar Merah Blok C2 No. 10<br>
                        Sidoarjo, Jawa Timur<br>
                        0819-8765-4321
                    </p>
                </td>
                
                <td width="50%" class="text-right">
                    <div class="section-title">PEMBAYARAN KE:</div>
                    <p style="margin: 0; line-height: 1.5;">
                        <strong>Bank BCA</strong><br>
                        No. Rek: 8291-293-112<br>
                        A/N: Amura Store Official<br><br>
                    </p>
                    <div class="section-title">DITANGANI OLEH:</div>
                    <p style="margin: 0; line-height: 1.5;">
                        <strong>Zidan Rasyid Susanto</strong><br>
                        No. Telp: 0812-3456-7890<br>
                    </p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="45%">Deskripsi Barang</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th width="15%" class="text-right">Harga</th>
                    <th width="20%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Gunpla MG Barbatos 1/100</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 850.000</td>
                    <td class="text-right">Rp 850.000</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Action Base 4 Clear</td>
                    <td class="text-center">2</td>
                    <td class="text-right">Rp 125.000</td>
                    <td class="text-right">Rp 250.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mr. Color Thinner 400ml</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp 150.000</td>
                    <td class="text-right">Rp 150.000</td>
                </tr>
            </tbody>
        </table>

        <div class="total-box">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Rp 1.250.000</td>
                </tr>
                <tr>
                    <td>Pajak (11%):</td>
                    <td class="text-right">Rp 137.500</td>
                </tr>
                <tr>
                    <td>Diskon:</td>
                    <td class="text-right text-muted">- Rp 0</td>
                </tr>
                <tr>
                    <td class="grand-total">Total Tagihan:</td>
                    <td class="text-right grand-total">Rp 1.387.500</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="note-box">
            <p style="margin: 0; font-size: 12px; color: #555; line-height: 1.5;">
                <strong>Catatan Penting:</strong><br>
                Mohon cantumkan <b>Nomor Faktur (' . $inv_no . ')</b> pada berita acara transfer bank Anda. Pembayaran yang melewati batas waktu jatuh tempo dapat menyebabkan penundaan pengiriman barang. Terima kasih telah berbelanja di Amura Store!
            </p>
        </div>

    </body>
    </html>
    ';

    // 3. Konfigurasi DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    
    // Setting ukuran kertas (A4 Portrait)
    $dompdf->setPaper('A4', 'portrait');
    
    // Render PDF
    $dompdf->render();

    // 4. Output
    if ($action == 'download') {
        $dompdf->stream("Invoice_" . $inv_no . ".pdf", array("Attachment" => 1));
    } else {
        $dompdf->stream("Invoice_" . $inv_no . ".pdf", array("Attachment" => 0));
    }
    exit;
}
?>