<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>bpSport</title>
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
        <!--konten-->
        <section class="konten">
            <div class="container">
                <h1>Produk Terbaru</h1>
            
            <div class="row">

            <?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
            <?php while($perproduk = $ambil->fetch_assoc()){ ?>
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="fotoproduk/<?php echo $perproduk['foto_produk'];?>"alt="">
                        
                        <div class="caption">
                            <h3><?php echo $perproduk['nama_produk'];?></h3>
                            <h5>Rp. <?php echo number_format($perproduk['harga_produk']);?></h5>
                            <a href="beli.php?id=<?php echo $perproduk['id_produk'];?>" class="btn btn-primary">Beli</a>
                            <a href="detail.php?id=<?php echo $perproduk["id_produk"];?>" class="btn btn-default">detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
        </section>
    </body>
</html>