<?php
function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}

function cekKelulusan($nilai) {
    return ($nilai >= 60) ? "LULUS" : "TIDAK LULUS";
}

$hargaAkhir = hitungDiskon(150000, 10);
echo "Harga setelah diskon: Rp" . number_format($hargaAkhir, 0, ",", ".") . "<br>";
echo "Status Kelulusan (Nilai 75): " . cekKelulusan(75);
?>