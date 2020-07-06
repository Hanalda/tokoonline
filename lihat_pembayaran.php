<?php 
session_start();
include 'koneksi.php';

$id_pembelian = $_GET["id"];

$ambil = $koneksi->query("SELECT * FROM pembayaran
        LEFT JOIN pembelian ON pembayaran.id_pembelian pembelian.id_pembelian
        WHERE pembelian.id_pembelian='$id_pembelian'");
$detbay = $ambil->fetch_assoc();

//echo "<pre>";
//print_r($detbay);
//echo "</pre>";
//jika blm ada data pembayaran 
if(empty($detbay))
{
    echo "<script>alert('anda tidak berhak')</script>";
    echo "<script>location='riwayat.php;</script>";
    exit(); 
}
//jika data pelangan pembayaran tidak sesuai 
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
if($_SESSION['pelanggan']['id_pelanggan']!==$detbay["id_pelanggan"])
{
    echo "<script>alert('anda tidak berhak melihat pembayaran orang lain')</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lihat Pembayaran</title>
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
                    <li><a href="riwayat.php">Riwayat Belanja</a></li>
                    <li><a href="logout.php">Logout</a></li>

                <li><a href="checkout.php">Checkout</a></li>
            </ul>
            </div>
        </nav>
        <div class="container">
            <h3>Lihat Pembayaran</h3>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td><?php echo $detbay["nama"]?></td>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td><?php echo $detbay["bank"]?></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td><?php echo $detbay["tanggal"]?></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp. <?php echo number_format($detbay["jumlah"])?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6"></div>
                <img src="buktipembayaran/<?php echo $detbay["bukti"]?>" class="img-responsive">
            </div>
        </div>
</body>
</html>