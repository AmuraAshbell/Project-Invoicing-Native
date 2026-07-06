<?php
// 1. Panggil autoload dari Composer
require 'vendor/autoload.php';

// 2. Import class Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// 3. Setup Opsi (Opsional, agar gambar/CSS terbaca lebih baik)
$options = new Options();
$options->set('isRemoteEnabled', true); // Penting jika pakai Bootstrap CDN
$dompdf = new Dompdf($options);

// 4. Masukkan kode HTML yang mau dicetak
$html = '<h1>Halo Zidan!</h1><p>Ini adalah test PDF dari DOMPDF.</p>';
$dompdf->loadHtml($html);

// 5. Atur ukuran kertas
$dompdf->setPaper('A4', 'portrait');

// 6. Render HTML ke PDF
$dompdf->render();

// 7. Output ke Browser (Attachment: 0 agar preview di browser, 1 agar langsung download)
$dompdf->stream("document.pdf", array("Attachment" => 0));
?>