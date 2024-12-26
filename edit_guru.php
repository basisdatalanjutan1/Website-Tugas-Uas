<?php
session_start();
include("inc_koneksi.php");

// Pastikan pengguna memiliki akses
if (!in_array("guru", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Tangani pengambilan data untuk diedit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM guru WHERE id = $id";
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
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE guru SET nama = '$nama', mata_pelajaran = '$mata_pelajaran', email = '$email' WHERE id = $id";
    if (mysqli_query($koneksi, $updateQuery)) {
        header("Location: admin_guru.php");
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
    <title>Edit Guru</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>

<body>
    <div id="app">
        <h1>Edit Data Guru</h1>
        <form method="POST">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required><br><br>

            <label for="mata_pelajaran">Mata Pelajaran:</label><br>
            <input type="text" id="mata_pelajaran" name="mata_pelajaran" value="<?php echo htmlspecialchars($data['mata_pelajaran']); ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required><br><br>

            <button type="submit">Simpan Perubahan</button>
            <a href="admin_guru.php">Batal</a>
        </form>
    </div>
</body>

</html>
