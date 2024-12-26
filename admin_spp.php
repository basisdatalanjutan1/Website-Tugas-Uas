<?php
include("inc_header.php");

if (!in_array("spp", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Query untuk mendapatkan data SPP
$query = "SELECT * FROM spp ORDER BY id DESC"; // Ganti dengan query yang sesuai
$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil
if (!$result) {
    // Jika query gagal, tampilkan pesan error
    echo "Error: " . mysqli_error($koneksi);
    include("inc_footer.php");
    exit();
}

?>
<div id="app">
    <h1>Halaman SPP</h1>
    <p>Selamat datang di halaman SPP. Gunakan fitur yang tersedia untuk mengelola data pembayaran SPP.</p>
    <style>
        #app {
            position: relative; 
        }

        #app a.btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: green;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>

<!-- Statistik Pembayaran -->
<div class="stats-container">
    <div class="stats-box">
        <h3>Total Siswa Lunas</h3>
        <p>35</p> <!-- Data dummy, sesuaikan dengan query -->
    </div>
    <div class="stats-box">
        <h3>Total Siswa Belum Lunas</h3>
        <p>10</p> <!-- Data dummy -->
    </div>
    <div class="stats-box">
        <h3>Total Pembayaran Diterima</h3>
        <p>Rp 5,000,000</p> <!-- Data dummy -->
    </div>
</div>

<!-- Form Pencarian -->
<form method="GET" action="spp_cari.php" class="search-form">
    <input type="text" name="keyword" placeholder="Cari Nama/NIS/Bulan" required>
    <button type="submit">Cari</button>
</form>

<!-- Tabel Data Pembayaran -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Bulan</th>
            <th>Nominal</th>
            <th>Tanggal Bayar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_siswa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                echo "<td>" . htmlspecialchars($row['bulan']) . "</td>";
                echo "<td>Rp " . number_format($row['nominal'], 0, ',', '.') . "</td>";
                echo "<td>" . htmlspecialchars($row['tanggal_bayar']) . "</td>";
                echo "<td>" . ($row['status'] == 'Lunas' ? "<span class='lunas'>Lunas</span>" : "<span class='belum-lunas'>Belum Lunas</span>") . "</td>";
                echo "<td>";
                echo "<a href='spp_edit.php?id=" . $row['id'] . "'>Edit</a> | ";
                echo "<a href='spp_hapus.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='no-data'>Data tidak ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Tombol Tambah Data -->
<div class="add-data">
    <a href="spp_tambah.php" class="btn">Tambah Data SPP</a>
</div>

<?php
include("inc_footer.php");
?>
