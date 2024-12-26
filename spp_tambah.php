<?php
include("inc_header.php");

if (!in_array("spp", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
    $nominal = mysqli_real_escape_string($koneksi, $_POST['nominal']);
    $tanggal_bayar = mysqli_real_escape_string($koneksi, $_POST['tanggal_bayar']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Query untuk menambahkan data
    $query = "INSERT INTO spp (nama_siswa, kelas, bulan, nominal, tanggal_bayar, status) 
              VALUES ('$nama_siswa', '$kelas', '$bulan', '$nominal', '$tanggal_bayar', '$status')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil ditambahkan.'); window.location.href = 'admin_spp.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data.'); window.location.href = 'spp_tambah.php';</script>";
    }
}
?>

<h1>Tambah Data SPP</h1>

<form method="POST" action="spp_tambah.php">
    <div class="form-group">
        <label for="nama_siswa">Nama Siswa</label>
        <input type="text" id="nama_siswa" name="nama_siswa" required>
    </div>
    <div class="form-group">
        <label for="kelas">Kelas</label>
        <input type="text" id="kelas" name="kelas" required>
    </div>
    <div class="form-group">
        <label for="bulan">Bulan</label>
        <input type="text" id="bulan" name="bulan" required>
    </div>
    <div class="form-group">
        <label for="nominal">Nominal</label>
        <input type="number" id="nominal" name="nominal" required>
    </div>
    <div class="form-group">
        <label for="tanggal_bayar">Tanggal Bayar</label>
        <input type="date" id="tanggal_bayar" name="tanggal_bayar" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="Lunas">Lunas</option>
            <option value="Belum Lunas">Belum Lunas</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit">Tambah Data</button>
    </div>
</form>

<?php
include("inc_footer.php");
?>
