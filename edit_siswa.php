<?php
session_start();
include("inc_koneksi.php");

// Pastikan pengguna memiliki akses
if (!in_array("siswa", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Tangani pengambilan data untuk diedit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM siswa WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        include("inc_footer.php");
        exit();
    }
} else {
    echo "ID tidak valid.";
    include("inc_footer.php");
    exit();
}

// Tangani pengiriman form untuk menyimpan perubahan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $kelas = $_POST['kelas'];

    $updateQuery = "UPDATE siswa SET nama = '$nama', umur = '$umur', kelas = '$kelas' WHERE id = $id";
    if (mysqli_query($koneksi, $updateQuery)) {
        header("Location: admin_siswa.php");
        exit();
    } else {
        echo "Gagal menyimpan perubahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit siswa</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>

<body>
    <div id="app">
        <h1>Edit Data siswa</h1>
        <form method="POST">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required><br><br>

            <label for="umur">Mata Pelajaran:</label><br>
            <input type="text" id="umur" name="umur" value="<?php echo htmlspecialchars($data['umur']); ?>" required><br><br>

            <label for="kelas">kelas:</label><br>
            <input type="kelas" id="kelas" name="kelas" value="<?php echo htmlspecialchars($data['kelas']); ?>" required><br><br>

            <button type="submit">Simpan Perubahan</button>
            <a href="admin_siswa.php">Batal</a>
        </form>
    </div>
</body>

</html>
