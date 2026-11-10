<?php
$data = null;
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    // Validasi Server-Side
    if ($nama === "") $error[] = "Nama wajib diisi.";
    if ($nim === "") $error[] = "NIM wajib diisi.";
    if ($prodi === "") $error[] = "Program studi wajib diisi.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }

    if (!ctype_digit((string)$semesterInput) || (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1-14.";
    }

    // Jika tidak ada error, simpan data ke variabel
    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Project - Data Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; line-height: 1.6; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 500px; }
        .error { color: #d9534f; background: #fdf7f7; border: 1px solid #d9534f; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .success { color: #3c763d; background: #dff0d8; border: 1px solid #3c763d; padding: 15px; border-radius: 4px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"], input[type="email"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 15px; background: #0275d8; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button[type="reset"] { background: #6c757d; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Formulir Data Mahasiswa</h2>

        <!-- Tampilkan Pesan Error (Jika Ada) -->
        <?php if (!empty($error)): ?>
            <div class="error">
                <strong>Terjadi Kesalahan:</strong>
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, "UTF-8") ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Tampilkan Ringkasan Data (Jika Valid) -->
        <?php if ($data): ?>
            <div class="success">
                <h3>Data Mahasiswa Berhasil Diterima</h3>
                <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama'], ENT_QUOTES, "UTF-8") ?></p>
                <p><strong>NIM:</strong> <?= htmlspecialchars($data['nim'], ENT_QUOTES, "UTF-8") ?></p>
                <p><strong>Program Studi:</strong> <?= htmlspecialchars($data['prodi'], ENT_QUOTES, "UTF-8") ?></p>
                <p><strong>Semester:</strong> <?= htmlspecialchars($data['semester'], ENT_QUOTES, "UTF-8") ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($data['email'], ENT_QUOTES, "UTF-8") ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulir Input -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '', ENT_QUOTES, "UTF-8") ?>">
            </div>

            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($_POST['nim'] ?? '', ENT_QUOTES, "UTF-8") ?>">
            </div>

            <div class="form-group">
                <label for="prodi">Program Studi:</label>
                <input type="text" id="prodi" name="prodi" value="<?= htmlspecialchars($_POST['prodi'] ?? '', ENT_QUOTES, "UTF-8") ?>">
            </div>

            <div class="form-group">
                <label for="semester">Semester (1-14):</label>
                <input type="number" id="semester" name="semester" value="<?= htmlspecialchars($_POST['semester'] ?? '', ENT_QUOTES, "UTF-8") ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, "UTF-8") ?>">
            </div>

            <button type="submit">Kirim Data</button>
            <button type="reset">Reset</button>
        </form>
    </div>

</body>
</html>