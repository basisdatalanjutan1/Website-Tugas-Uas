<?php
// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "sekolah");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek jika ada parameter id pada URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM spp WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil dihapus, arahkan kembali ke halaman daftar SPP
        header("Location: admin_spp.php");
        exit();
    } else {
        // Jika terjadi error dalam query
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak ditemukan!";
}

// Menutup koneksi
mysqli_close($koneksi);
?>
