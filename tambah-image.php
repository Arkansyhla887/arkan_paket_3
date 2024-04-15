<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
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
            <h3>Tambah Data Foto</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                    $result = mysqli_query($conn,"SELECT * FROM tbl_category");
                    $jsArray = "var prdName = new Array();\n";
                    echo '<select class="input-control" name="kategori" onchange="document.getElementById(\'prd_name\').value = prdName[this.value]" required>';
                    echo '<option value="">- Pilih Kategori Foto -</option>';
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                        $jsArray .= "prdName['" . $row['category_id'] . "'] = '" . addslashes($row['category_name']) . "';\n";
                    }
                    echo '</select>';
                    ?>
                    <input type="hidden" name="nama_kategori" id="prd_name">
                    <input type="hidden" name="adminid" value="<?php echo $_SESSION['user_global']->id ?>">
                    <input type="hidden" name="namaadmin" class="input-control" value="<?php echo $_SESSION['user_global']->username ?>" readonly="readonly">
                    <input type="text" name="nama" class="input-control" placeholder="Nama Foto" required>
                    <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br />
                    <input type="file" name="gambar" class="input-control" required>
                    <select class="input-control" name="status">
                        <option value="">-- Pilih --</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option> 
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                if(isset($_POST['submit'])){
                    $kategori   = $_POST['kategori'];
                    $nama_ka    = $_POST['nama_kategori'];
                    $admin_id   = $_POST['adminid'];
                    $nama_admin = $_POST['namaadmin'];
                    $nama       = $_POST['nama'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];
                    
                    $filename   = $_FILES['gambar']['name'];
                    $tmp_name   = $_FILES['gambar']['tmp_name'];
                    
                    $type1      = explode('.', $filename);
                    $type2      = $type1[1];
                    $newname    = 'foto'.time().'.'.$type2; 
                    
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
                    
                    if(!in_array($type2, $tipe_diizinkan)){
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    }else{
                        move_uploaded_file($tmp_name, './foto/'.$newname);
                        
                        // Membuat album secara otomatis jika belum ada
                        $result = mysqli_query($conn, "SELECT id FROM tbl_album WHERE user_id = '".$admin_id."' AND nama_album = '".$nama_ka."'");
                        if(mysqli_num_rows($result) == 0){ // Jika album belum ada
                            $insert_album = mysqli_query($conn, "INSERT INTO tbl_album (nama_album, deskripsi, tanggal_buat, user_id) VALUES ('".$nama_ka."', '', NOW(), '".$admin_id."')");
                            if(!$insert_album){
                                echo 'Gagal membuat album: '.mysqli_error($conn);
                                exit; // Keluar dari skrip jika gagal membuat album
                            }
                            $album_id = mysqli_insert_id($conn); // Ambil ID album baru
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            $album_id = $row['id']; // Gunakan ID album yang sudah ada
                        }
                        
                        // Simpan foto ke dalam album yang sesuai
                        $insert = mysqli_query($conn, "INSERT INTO tbl_foto (judul_foto, deskripsi_foto, tanggal_unggah, lokasi_file, album_id, user_id) VALUES (
                            '".$nama."',
                            '".$deskripsi."',
                            NOW(),
                            '".$newname."',
                            '".$album_id."',
                            '".$admin_id."'
                        ) ");
                                        
                        if($insert){
                            echo '<script>alert("Tambah Foto berhasil")</script>';
                            echo '<script>window.location="data-image.php"</script>';
                        }else{
                            echo 'Gagal: '.mysqli_error($conn);
                        }
                    }
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
    <script>
        CKEDITOR.replace( 'deskripsi' );
    </script>
    <script type="text/javascript"><?php echo $jsArray; ?></script>
</body>
</html>
