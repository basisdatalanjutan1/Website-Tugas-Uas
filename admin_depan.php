<?php
include("inc_header.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Depan</title>
    <style>
        
        body {
        background-color:rgb(255, 255, 255); /* Menambahkan warna latar belakang */
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Jika Anda ingin memberi warna latar belakang khusus untuk halaman admin_depan */
    #app {
        background-color:rgb(255, 255, 255); /* Warna latar belakang untuk konten utama */
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Menambah efek bayangan */
    }


.welcome-container {
    text-align: center;
    margin-top: 50px;
}

.logo img {
    border-radius: 10px;
    margin-bottom: 20px;
}

h1 {
    color: #2C3E50;
    font-size: 36px;
}

p {
    font-size: 18px;
    color: #7F8C8D;
}
</style>
</head>
<body>
    <div id="app" class="welcome-container">
        <!-- Logo Sekolah -->
        <div class="logo">
            <img src="logo.png" alt="Logo Sekolah" width="500">
        </div>
        
        <!-- Selamat datang di Sekolah IT -->
        <h1>Selamat datang di Sekolah IT</h1>
        <p>Menjadi bagian dari komunitas belajar yang modern dan inovatif.</p>
    </div>

    <?php
    include("inc_footer.php");
    ?>
</body>
</html>
