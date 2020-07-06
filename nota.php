<?php 
session_start();
include 'koneksi.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembelian</title>
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
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="logout.php">Logout</a></li>

                <li><a href="checkout.php">Checkout</a></li>
            </ul>
            </div>
        </nav>

        <section class="konten">
        <div class="container">
        
        <!--nota disini copas saja dari nota yang ada di admin -->
        <h2>Detail Pembelian</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan 
                ON pembelian.id_pelanggan=pelanggan.id_pelanggan
                WHERE pembelian.id_pembelian='$_GET[id]'");
                $detail = $ambil->fetch_assoc();
                ?>
<h1>Data orang yang beli $detail</h1>
<pre><?php print_r($detail);?></pre>

<h1>data orang yang login di session</h1>
<pre><?php print_r($_SESSION) ?></pre>

<!--jika pelanggan yang beli tidak sama dengan pelanggan yang login
maka dilarikan ke riwayat.php karena dia tidak berhak melihat nota orang lain-->

<!--pelanggan yang beli harus pelanggan yang login-->
<?php
//mendapatkan id_pelanggan yang beli 
$idpelangganygbeli = $detail["id_pelanggan"];
//mendapatkan id_pelanggan yg login
$idpelangganyglogin=$_SESSION["pelanggan"]["id_pelanggan"];
if($idpelangganygbeli!==$idpelangganyglogin)
{
    echo "<script>alert('jangan nakal ya');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>

    <div class="row">
        <div class="col-md-4">
            <h3>Pembelian</h3>
            <strong>No. Pembelian:<?php echo $detail['id_pembelian']?></strong><br>
            Tanggal : <?php echo $detail['tanggal_pembelian'];?><br>
            Total : Rp. <?php echo number_format($detail['total_pembelian'])?>
        </div>
        <div class="col-md-4">
        <h3>Pelanggan</h3>
        <strong><?php echo $detail['nama_pelanggan']?></strong>
        <p>
            <?php echo $detail['telepon_pelanggan']; ?> <br>
            <?php echo $detail['email_pelanggan']; ?>
        </p>
        </div>
        <div class="col-md-4">
        <h3>Pengiriman</h3>
        <strong><?php echo $detail['nama_kota']?></strong><br>
        Ongkos Kirim: Rp. <?php echo number_format($detail['tarif']); ?><br>
        Alamat : <?php echo $detail['alamat_pengiriman']?>
        </div>
    </div>

<table class="table table bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1;?>
        <?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
        <?php while($pecah = $ambil->fetch_assoc()){?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama']; ?></td>
            <td>Rp. <?php echo number_format($pecah['harga']); ?></td>
            <td><?php echo $pecah['jumlah']; ?></td>
            <td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>

<div class="row">
        <div class="col-md-7">
            <div class="alert alert-info">
            <p>
                silahkan melakukan pembayaran Rp. <?php echo number_format(
                    $detail['total_pembelian']); ?> ke <br>
                    <strong>BANK BRI 128-001234-5678 AN.Hanalda</strong>
            </p>
            </div>
        </div>
</div>

        </div>
        </section>
</body>
</html>