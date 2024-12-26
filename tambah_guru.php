<?php
session_start();
include("inc_koneksi.php");

// Pastikan pengguna memiliki akses
if (!in_array("guru", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Tangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mata_pelajaran = mysqli_real_escape_string($koneksi, $_POST['mata_pelajaran']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $insertQuery = "INSERT INTO guru (nama, mata_pelajaran, email) VALUES ('$nama', '$mata_pelajaran', '$email')";
    if (mysqli_query($koneksi, $insertQuery)) {
        header("Location: admin_guru.php");
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
    <title>Tambah Guru</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>

<body>
    <div id="app">
        <h1>Tambah Guru Baru</h1>
        <form method="POST">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="mata_pelajaran">Mata Pelajaran:</label><br>
            <input type="text" id="mata_pelajaran" name="mata_pelajaran" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <button type="submit">Simpan</button>
            <a href="admin_guru.php">Batal</a>
        </form>
    </div>
</body>

</html>
