<?php
    include 'db.php';
    session_start();
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $data = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '$id'");
        $row = mysqli_fetch_assoc($data);
        if(mysqli_num_rows($data) == 0){
            echo '<script>window.location="data-image.php"</script>';
        }
    }

    if(isset($_POST['submit'])){
        // ambil data dari form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        $update = mysqli_query($conn, "UPDATE tb_image SET 
        image_name = '$name',
        image_description = '$description',
        image_status = '$status'
        WHERE image_id = '$id'");
        if($update){
            echo '<script>alert("Data berhasil diupdate");window.location="data-image.php"</script>';
        } else {
            echo 'Gagal' . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Foto</title>
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
                <li><a href="Keluar.php">Keluar</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Edit Data Foto</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $row['image_id'] ?>">
                    <div class="input-group">
                        <label>Nama Foto</label>
                        <input type="text" name="name" class="input-control" value="<?= $row['image_name'] ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Deskripsi</label>
                        <textarea class="input-control" name="description" required><?= $row['image_description'] ?></textarea>
                    </div>
                    <div class="input-group">
                        <label>Status</label>
                        <select class="input-control" name="status" required>
                            <option value="1" <?= $row['image_status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $row['image_status'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <button type="submit" class="btn" name="submit">Update</button>
                    </div>
                </form>
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
