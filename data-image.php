<?php
    session_start();
    include 'db.php'; // Sesuaikan dengan file yang berisi koneksi ke database

    // Periksa apakah pengguna sudah login
    if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
        exit; // Keluar untuk menghentikan eksekusi lebih lanjut
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEB Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">WEB GALERI FOTO</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-image.php">Data Foto</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </div>
    </header>
        
    <!-- Content -->
    <div class="section">
        <div class="container">
            <h3>Data Galeri Foto</h3>
            <div class="box">
                <p><a href="tambah-image.php" class="btn">Tambah Data</a></p><br>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Kategori</th>
                            <th>Nama User</th>
                            <th>Nama Foto</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <!-- <th>Status</th> -->
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $userId = $_SESSION['id']; // Sesuaikan dengan session yang menyimpan ID pengguna
                            $query = "SELECT tbl_foto.*, tbl_album.nama_album, tbl_user.username 
                                      FROM tbl_foto 
                                      LEFT JOIN tbl_album ON tbl_foto.album_id = tbl_album.id
                                      LEFT JOIN tbl_user ON tbl_foto.user_id = tbl_user.id
                                      WHERE tbl_foto.user_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $userId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_album'] ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['judul_foto'] ?></td>
                            <td><?php echo $row['deskripsi_foto'] ?></td>
                            <td><a href="foto/<?php echo $row['lokasi_file'] ?>" target="_blank"><img src="foto/<?php echo $row['lokasi_file'] ?>" width="50px"></a></td>
                            <!-- <td><?php echo ($row['status'] == 0) ? 'Tidak Aktif' : 'Aktif'; ?></td> -->
                            <td>
                                <a href="edit-image.php?id=<?php echo $row['id'] ?>" class="btn">Edit</a> 
                                <a href="proses-hapus.php?idp=<?php echo $row['id'] ?>" onclick="return confirm('Yakin Ingin Hapus ?')" class="btn">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="8">Tidak ada data</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <small>&copy; 2024 - Web Galeri Foto.</small>
        </div>
    </footer>
</body>
</html>
