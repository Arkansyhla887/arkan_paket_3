<?php
session_start();
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){
    echo '<script>window.location="login.php"</script>';
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WEB Galeri Foto</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="dashboard.php">WEB GALERI FOTO</a></h1>
        <ul>
           <li><a href="dashboard.php">Dashboard</a></li>
           <li><a href="profil.php">Profil</a></li>
           <li><a href="data-image.php">Data Foto</a></li>
           <li><a href="logout.php">Keluar</a></li> <!-- Perbaikan pada tautan Keluar -->
        </ul>
        </div>
    </header>
    
    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="box">
                <?php
                // Memastikan bahwa informasi user telah diset dalam session sebelum mencoba mengaksesnya
                if(isset($_SESSION['user_global'])) {
                    echo '<h4>Selamat Datang ' . $_SESSION['user_global']->nama_lengkap . ' di Website Galeri Foto</h4>'; // Menggunakan nama_lengkap dari objek user_global
                } else {
                    echo '<h4>Selamat Datang di Website Galeri Foto</h4>'; // Jika informasi user tidak tersedia, tampilkan pesan default
                }
                ?>
            </div>
        </div>
    </div>
    
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - Web Galeri Foto.</small>
        </div>
    </footer>
</body>
</html>
