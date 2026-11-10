<?php
function formatRupiah($angka) {
    return "Rp" . number_format((float)$angka, 0, ",", ".");
}

$hasilRataRata = null;
if (isset($_POST['hitung_rata'])) {
    $tugas = (float)($_POST['nilai_tugas'] ?? 0);
    $uts = (float)($_POST['nilai_uts'] ?? 0);
    $uas = (float)($_POST['nilai_uas'] ?? 0);
    $rataRata = ($tugas + $uts + $uas) / 3;
    $hasilRataRata = [
        'tugas' => $tugas,
        'uts' => $uts,
        'uas' => $uas,
        'rata' => $rataRata
    ];
}

$daftarMahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita", "Nur Muhammad Baha"];
$hasilCariGET = null;
if (isset($_GET['keyword']) && trim($_GET['keyword']) !== '') {
    $keyword = trim($_GET['keyword']);
    $hasilCariGET = array_filter($daftarMahasiswa, function($nama) use ($keyword) {
        return stripos($nama, $keyword) !== false;
    });
}

$hasilRupiah = null;
if (isset($_POST['konversi_rupiah'])) {
    $hargaInput = (float)($_POST['nominal_harga'] ?? 0);
    $hasilRupiah = formatRupiah($hargaInput);
}

$errorNIM = [];
$suksesNIM = null;
if (isset($_POST['kirim_nim'])) {
    $nimInput = trim($_POST['nim_mahasiswa'] ?? '');
    if ($nimInput === '') {
        $errorNIM[] = "NIM tidak boleh kosong.";
    } elseif (!ctype_digit($nimInput)) {
        $errorNIM[] = "NIM harus berisi angka saja (tanpa huruf/simbol).";
    } elseif (strlen($nimInput) !== 9) {
        $errorNIM[] = "Panjang NIM harus tepat 9 digit (Input saat ini: " . strlen($nimInput) . " digit).";
    } else {
        $suksesNIM = "NIM " . htmlspecialchars($nimInput, ENT_QUOTES, "UTF-8") . " Valid dan diterima server!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Eksperimen Mandiri Poin G</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; background-color: #f4f6f9; color: #222; }
        .box { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #222; border-bottom: 2px solid #444; padding-bottom: 5px; }
        .error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
        .success { color: #155724; background-color: #d4edda; padding: 12px; border-radius: 4px; margin-bottom: 10px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="number"] { padding: 8px; width: 300px; max-width: 100%; }
        button { padding: 8px 15px; background: #333; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        button:hover { background: #555; }
        button[type="reset"] { background: #6c757d; }
        button[type="reset"]:hover { background: #5a6268; }
    </style>
</head>
<body>

    <h1>Eksperimen Mandiri (Point G)</h1>

    <div class="box">
        <h2>1. Perhitungan Rata-Rata Tiga Komponen Nilai</h2>
        <form method="POST">
            <label>Nilai Tugas:</label>
            <input type="number" step="0.01" name="nilai_tugas" required value="<?= htmlspecialchars($_POST['nilai_tugas'] ?? '') ?>">
            
            <label>Nilai UTS:</label>
            <input type="number" step="0.01" name="nilai_uts" required value="<?= htmlspecialchars($_POST['nilai_uts'] ?? '') ?>">
            
            <label>Nilai UAS:</label>
            <input type="number" step="0.01" name="nilai_uas" required value="<?= htmlspecialchars($_POST['nilai_uas'] ?? '') ?>">
            <br>
            <button type="submit" name="hitung_rata">Hitung Rata-Rata</button>
        </form>

        <?php if ($hasilRataRata): ?>
            <div class="success" style="margin-top: 15px;">
                <p><strong>Nilai Tugas:</strong> <?= $hasilRataRata['tugas'] ?></p>
                <p><strong>Nilai UTS:</strong> <?= $hasilRataRata['uts'] ?></p>
                <p><strong>Nilai UAS:</strong> <?= $hasilRataRata['uas'] ?></p>
                <p><strong>Hasil Rata-Rata:</strong> <?= number_format($hasilRataRata['rata'], 2) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>2. Pencarian Nama Mahasiswa dari Array (Metode GET)</h2>
        <form method="GET">
            <label>Masukkan Nama / Kata Kunci:</label>
            <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Cari nama...">
            <button type="submit">Cari Data</button>
        </form>

        <?php if ($hasilCariGET !== null): ?>
            <h4 style="margin-bottom: 5px;">Hasil Filter Array:</h4>
            <?php if (!empty($hasilCariGET)): ?>
                <ul>
                    <?php foreach ($hasilCariGET as $nama): ?>
                        <li><?= htmlspecialchars($nama, ENT_QUOTES, "UTF-8") ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p style="color: red;">Nama tidak ditemukan dalam array.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>3. Function Format Harga Menjadi Rupiah</h2>
        <form method="POST">
            <label>Masukkan Nominal Angka:</label>
            <input type="number" step="0.01" name="nominal_harga" required value="<?= htmlspecialchars($_POST['nominal_harga'] ?? '') ?>">
            <br>
            <button type="submit" name="konversi_rupiah">Format ke Rupiah</button>
        </form>

        <?php if ($hasilRupiah !== null): ?>
            <div class="success" style="margin-top: 15px;">
                <p><strong>Hasil Format Rupiah:</strong> <?= $hasilRupiah ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>4. Validasi NIM (Angka & Panjang Ketentuan 9 Digit)</h2>
        
        <?php if (!empty($errorNIM)): ?>
            <div class="error">
                <?php foreach ($errorNIM as $err): ?>
                    <p style="margin:0;"><?= htmlspecialchars($err, ENT_QUOTES, "UTF-8") ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($suksesNIM): ?>
            <div class="success"><?= $suksesNIM ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Masukkan NIM (Wajib 9 Digit Angka):</label>
            <input type="text" name="nim_mahasiswa" value="<?= htmlspecialchars($_POST['nim_mahasiswa'] ?? '') ?>">
            <br>
            <button type="submit" name="kirim_nim">Uji Validasi NIM</button>
        </form>
    </div>

    <div class="box">
        <h2>5. Tombol Reset Form</h2>
        <form method="POST" onreset="document.getElementById('pesanResetSuccess').style.display='block';">
            <label>Uji Coba Pengisian Input:</label>
            <input type="text" placeholder="Ketik teks di sini untuk mencoba reset...">
            <br>
            <button type="reset">Tombol Reset (Client-side)</button>
        </form>

        <div id="pesanResetSuccess" class="success" style="display: none; margin-top: 15px;">
            Form berhasil direset!
        </div>

        <hr style="margin-top: 20px;">
        
    </div>

</body>
</html>