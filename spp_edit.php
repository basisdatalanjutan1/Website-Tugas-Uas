<?php
// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "sekolah");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data SPP berdasarkan ID
    $query = "SELECT * FROM spp WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak ditemukan!";
    exit();
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
    $nominal = mysqli_real_escape_string($koneksi, $_POST['nominal']);
    $tanggal_bayar = mysqli_real_escape_string($koneksi, $_POST['tanggal_bayar']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Query untuk update data SPP
    $update_query = "UPDATE spp SET 
                        nama_siswa = '$nama_siswa', 
                        kelas = '$kelas', 
                        bulan = '$bulan', 
                        nominal = '$nominal', 
                        tanggal_bayar = '$tanggal_bayar', 
                        status = '$status'
                    WHERE id = $id";

    if (mysqli_query($koneksi, $update_query)) {
        echo "Data berhasil diupdate!";
        header("Location: admin_spp.php"); // Redirect kembali ke halaman daftar SPP
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<h1>Edit Data SPP</h1>

<form method="POST" action="">
    <label for="nama_siswa">Nama Siswa:</label>
    <input type="text" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($data['nama_siswa']) ?>" required>

    <label for="kelas">Kelas:</label>
    <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required>

    <label for="bulan">Bulan:</label>
    <input type="text" id="bulan" name="bulan" value="<?= htmlspecialchars($data['bulan']) ?>" required>

    <label for="nominal">Nominal:</label>
    <input type="number" id="nominal" name="nominal" value="<?= htmlspecialchars($data['nominal']) ?>" required>

    <label for="tanggal_bayar">Tanggal Bayar:</label>
    <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="<?= htmlspecialchars($data['tanggal_bayar']) ?>" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Lunas" <?= $data['status'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
        <option value="Belum Lunas" <?= $data['status'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
    </select>

    <button type="submit">Update Data</button>
</form>

<a href="admin_spp.php">Kembali ke Daftar SPP</a>

<?php
// Menutup koneksi
mysqli_close($koneksi);
?>
