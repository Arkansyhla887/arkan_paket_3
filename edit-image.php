<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Mendapatkan ID foto dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo '<script>window.location="data-image.php"</script>';
}

// Mendapatkan data foto berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM tbl_foto WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEB Galeri Foto - Edit Data Foto</title>
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
            <li><a href="logout.php">Keluar</a></li>
        </ul>
    </div>
</header>

<!-- content -->
<div class="section">
    <div class="container">
        <h3>Edit Data Foto</h3>
        <div class="box">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="nama" class="input-control" placeholder="Nama Foto" value="<?php echo $data['judul_foto']; ?>" required>
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"><?php echo $data['deskripsi_foto']; ?></textarea><br />
                <input type="file" name="gambar" class="input-control">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $nama = $_POST['nama'];
                $deskripsi = $_POST['deskripsi'];
                // $status = $_POST['status'];

                // Mengambil data file yang diupload
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];

                // Jika ada file yang diupload
                if ($filename != '') {
                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];
                    $newname = 'foto' . time() . '.' . $type2;

                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    if (!in_array($type2, $tipe_diizinkan)) {
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    } else {
                        move_uploaded_file($tmp_name, './foto/' . $newname);
                        $lokasi_file = $newname;
                    }
                } else {
                    // Jika tidak ada file yang diupload, gunakan lokasi file lama
                    $lokasi_file = $data['lokasi_file'];
                }

                // Update data foto di database
                $update = mysqli_query($conn, "UPDATE tbl_foto SET judul_foto = '$nama', deskripsi_foto = '$deskripsi', lokasi_file = '$lokasi_file' WHERE id = '$id'");
                
                if ($update) {
                    echo '<script>alert("Edit Foto berhasil")</script>';
                    echo '<script>window.location="data-image.php"</script>';
                } else {
                    echo 'Gagal: ' . mysqli_error($conn);
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- footer -->
<footer>
    <div class="container">
        <small>&copy; 2024 - Web Galeri Foto.</small>
    </div>
</footer>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('deskripsi');
</script>
</body>
</html>
