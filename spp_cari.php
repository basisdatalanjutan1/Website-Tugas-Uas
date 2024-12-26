<?php
include("inc_header.php");

if (!in_array("spp", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if ($keyword) {
    // Query untuk mencari data berdasarkan nama, NIS, atau bulan
    $query = "SELECT * FROM spp WHERE nama_siswa LIKE '%$keyword%' OR kelas LIKE '%$keyword%' OR bulan LIKE '%$keyword%' ORDER BY id DESC";
    $result = mysqli_query($koneksi, $query);
} else {
    // Query jika tidak ada keyword
    $query = "SELECT * FROM spp ORDER BY id DESC";
    $result = mysqli_query($koneksi, $query);
}

?>

<h1>Hasil Pencarian SPP</h1>
<p>Menampilkan hasil pencarian untuk: <strong><?php echo htmlspecialchars($keyword); ?></strong></p>

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

<?php
include("inc_footer.php");
?>
