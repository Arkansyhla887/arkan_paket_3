<?php
    session_start();
    include 'db.php';

    if(isset($_POST['submit'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        $cek = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username = '$user' AND password = '$pass'");
        if(mysqli_num_rows($cek) > 0){
            $d = mysqli_fetch_object($cek);
            $_SESSION['status_login'] = true;
            $_SESSION['user_global'] = $d;
            $_SESSION['id'] = $d->id;
            echo '<script>window.location="dashboard.php"</script>';
        }else{
            echo '<script>alert("Username atau password anda salah")</script>';
        }
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | Web Galeri Foto</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body id="bg-login">
     <div class="box-login">
         <h2>Login</h2>
         <form action="" method="POST">
             <input type="text" name="user" placeholder="Username" class="input-control">
             <input type="password" name="pass" placeholder="Password" class="input-control">
             <input type="submit" name="submit" value="Login" class="btn">
         </form>
         <br />
         <p>Belum punya akun? Daftar <a style="color:#00C;" href="registrasi.php">DISINI</a></p>
         <p>Atau klik <a style="color:#00C;" href="index.php">Kembali</a></p>
      </div>
      
</body>
</html>
