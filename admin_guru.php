<?php
session_start();
include("inc_koneksi.php");
include("inc_header.php"); // Memanggil header agar tetap terlihat di halaman ini

if (!in_array("guru", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Pastikan ID adalah angka
    $deleteQuery = "DELETE FROM guru WHERE id = ?";
    
    // Menggunakan prepared statement untuk menghindari SQL Injection
    if ($stmt = mysqli_prepare($koneksi, $deleteQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $id); // Binding parameter ID (integer)
        if (mysqli_stmt_execute($stmt)) {
            // Redirect setelah penghapusan berhasil
            header("Location: admin_guru.php?status=success");
        } else {
            // Menampilkan pesan error jika gagal
            header("Location: admin_guru.php?status=error");
        }
        mysqli_stmt_close($stmt);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin Guru</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>
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

    #app a.btn.logout {
    position: absolute; /* Posisi absolut */
    top: 20px;          /* Jarak dari atas */
    right: 20px;        /* Jarak dari kanan */
    background-color: red;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}
    table {
        margin: 20px auto; /* Center the table */
        border-collapse: collapse;
        width: 80%;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center; /* Center text inside table */
    }

    table th {
        background-color: #4CAF50;
        color: white;
    }
</style>
<body>
    <div id="app">
        <h1>Halaman Admin Guru</h1>
        <p>Selamat datang di halaman admin guru</p>

        
        <a href="tambah_guru.php" class="btn">Tambah Guru</a> <!-- Tombol Tambah Guru -->

        <!-- Form Pencarian -->
        <form method="GET">
            <input type="text" name="search" placeholder="Cari Guru..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
            <input type="submit" value="Cari" />
        </form>

        <!-- Notifikasi Status -->
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<p class='success'>Guru berhasil dihapus.</p>";
            } elseif ($_GET['status'] == 'error') {
                echo "<p class='error'>Terjadi kesalahan saat menghapus guru.</p>";
            }
        }
        ?>

        <!-- Tabel Guru -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Mata Pelajaran</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Cek apakah ada parameter pencarian
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $query = "SELECT id, nama, mata_pelajaran, email FROM guru WHERE nama LIKE ?";
                } else {
                    $query = "SELECT id, nama, mata_pelajaran, email FROM guru";
                }

                // Jalankan query
                if ($stmt = mysqli_prepare($koneksi, $query)) {
                    if (isset($search)) {
                        $search_param = "%$search%";
                        mysqli_stmt_bind_param($stmt, "s", $search_param); // Binding parameter pencarian
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Mengecek apakah query berhasil
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['mata_pelajaran'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_guru.php?id=" . $row['id'] . "'>Edit</a> | ";
                            echo "<a href='admin_guru.php?delete=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>Data tidak ditemukan</td></tr>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "<tr><td colspan='5' class='no-data'>Terjadi kesalahan dalam query</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    include("inc_footer.php"); // Menutup footer
    ?>
</body>

</html>

