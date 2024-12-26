<?php
session_start();
include("inc_koneksi.php");

// Pastikan pengguna memiliki akses
if (!in_array("siswa", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Tangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);

    $insertQuery = "INSERT INTO siswa (nama, umur, kelas) VALUES ('$nama', '$umur', '$kelas')";
    if (mysqli_query($koneksi, $insertQuery)) {
        header("Location: admin_siswa.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah siswa</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>

<body>
    <div id="app">
        <h1>Tambah siswa Baru</h1>
        <form method="POST">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="umur">Mata Pelajaran:</label><br>
            <input type="text" id="umur" name="umur" required><br><br>

            <label for="kelas">kelas:</label><br>
            <input type="kelas" id="kelas" name="kelas" required><br><br>

            <button type="submit">Simpan</button>
            <a href="admin_siswa.php">Batal</a>
        </form>
    </div>
</body>

</html>
