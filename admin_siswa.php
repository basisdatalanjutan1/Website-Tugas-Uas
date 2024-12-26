<?php
session_start();
include("inc_koneksi.php");
include("inc_header.php"); // Memanggil header agar tetap terlihat di halaman ini

// Mengecek apakah user memiliki akses
if (!in_array("siswa", $_SESSION['admin_akses'])) {
    echo "Kamu tidak punya akses";
    include("inc_footer.php"); // Menyertakan footer saat akses dibatasi
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Pastikan ID adalah angka
    $deleteQuery = "DELETE FROM siswa WHERE id = ?";

    // Menggunakan prepared statement untuk menghindari SQL Injection
    if ($stmt = mysqli_prepare($koneksi, $deleteQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $id); // Binding parameter ID (integer)
        if (mysqli_stmt_execute($stmt)) {
            header("Location: admin_siswa.php?status=success");
        } else {
            header("Location: admin_siswa.php?status=error");
        }
        mysqli_stmt_close($stmt);
    }
    exit();
}

// Mengatur apakah user ingin logout atau tidak
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Siswa</title>
    <link rel="stylesheet" href="style.css"> <!-- Menautkan file CSS -->
</head>
    <style>
     #app {
        position: relative; 
        margin-top: 15px; /* Mengatur margin atas jika diperlukan */
    padding: 10px; /* Sesuaikan padding jika diperlukan */
    }

    #app a.btn {
        display: inline-block;
        margin: 20px;
        padding: 10px 15px;
        text-decoration: none;
        color: white;
        background-color: green;
        border-radius: 5px;
        font-size: 16px;
    }
    body {
    background: none; /* Menghapus background pada halaman */
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}
table {
        margin: 20px auto; /* Center the table */
        border-collapse: collapse;
        width: 50%;
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
        <h1>Halaman Siswa</h1>
        <p>Selamat datang di halaman siswa</p>

        

        <!-- Tombol Tambah Siswa -->
        <a href="tambah_siswa.php" class="btn">Tambah Siswa</a>

        <!-- Form Pencarian -->
        <form method="GET">
            <input type="text" name="search" placeholder="Cari Siswa..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
            <input type="submit" value="Cari" />
        </form>

        <!-- Notifikasi Status -->
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<p class='success'>Siswa berhasil dihapus.</p>";
            } elseif ($_GET['status'] == 'error') {
                echo "<p class='error'>Terjadi kesalahan saat menghapus siswa.</p>";
            }
        }
        ?>

        <!-- Tabel Siswa -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Cek apakah ada parameter pencarian
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $query = "SELECT id, nama, umur, kelas FROM siswa WHERE nama LIKE ?";
                } else {
                    $query = "SELECT id, nama, umur, kelas FROM siswa";
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
                            echo "<td>" . $row['umur'] . "</td>";
                            echo "<td>" . $row['kelas'] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_siswa.php?id=" . $row['id'] . "'>Edit</a> | ";
                            echo "<a href='admin_siswa.php?delete=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>";
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
