<?php
include 'db.php';

if(isset($_GET['idp'])){
    // Ambil lokasi file gambar dari database
    $foto = mysqli_query($conn, "SELECT lokasi_file FROM tbl_foto WHERE id = '".$_GET['idp']."' ");
    $p = mysqli_fetch_object($foto);
    
    // Hapus file gambar dari direktori
    unlink('./foto/'.$p->lokasi_file);
    
    // Hapus data foto dari database
    $delete = mysqli_query($conn, "DELETE FROM tbl_foto WHERE id = '".$_GET['idp']."' ");
    if($delete) {
        echo '<script>window.location="data-image.php"</script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
