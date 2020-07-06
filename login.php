<?php 
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>login pelanggan</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

            <!-- navbar -->
            <nav class="navbar navbar-default">
            <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="keranjang.php">Keranjang</a></li>
                <!-- jika sudah login(ada session pelanggan)-->
                <?php if(isset($_SESSION["pelanggan"]));?>

                    <li><a href="login.php">Login</a></li>
                    <li><a href="daftar.php">Daftar</a></li>
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
            </div>
        </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login Pelanggan</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                            </div>
                            <button class="btn btn-primary" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    //jika ada tombol login(tombol login ditekan)
    if(isset($_POST["login"]))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        //lakukan query mengecek akun dari tabel pelanggan di database
        $ambil = $koneksi->query("SELECT * FROM pelanggan
        WHERE email_pelanggan='$email' AND password_pelanggan='$password'"); 
        
        //menghitung akun yang terambil 
        $akunygcocok = $ambil->num_rows;

        //jika satu akun yang cocok maka diloginkan
        if($akunygcocok==1)
        {
            //anda sudah login
            //mendapatkan akun dalam bentuk array
            $akun = $ambil->fetch_assoc();
            //simpan di session pelanggan 
            $_SESSION["pelanggan"] = $akun;
            echo "<script>alert('anda sukses login');</script>";

            //jika sudah belanja
            if(isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"]))
            {
                echo "<script>location='checkout.php';</script>";
            }
            else
            {
                echo "<script>location='riwayat.php';</script>";
            }
        }
        else
        {
            //anda gagal login
            echo"<script>alert('anda gagal login, periksa akun anda');</script>";
            echo"<script>location='login.php';</script>";

        }
}
    ?>
</body>
</html>