<?php
session_start();
include 'koneksi.php';
//jika tidak ada session pelanggan
if(!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"]))
{
    echo "<script>alert('silahkan login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

//mendapatkan id_pembelian dari url 
$idpem = $_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
$detailpem = $ambil->fetch_assoc();

//mendapatkan id_pelanggan yang beli 
$id_pelanggan_beli = $detailpem["id_pelanggan"];
//mendapatkan id_pelanggan yang login
$id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if($id_pelanggan_login !==$id_pelanggan_beli)
{
    echo "<script>alert('jangan nakal');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
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
            <h2>Konfirmasi Pembayaran</h2>
            <p>Kirim bukti pembayaran anda disini</p>

            <div class="alert alert-info">total tagihan anda <strong>Rp. <?php 
            echo number_format($detailpem["total_pembelian"])?></strong></div>

            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Penyetor</label>
                    <input type="text" class="form-control" name="nama">
                </div>
                <div class="form-group">
                    <label>Bank</label>
                    <input type="text" class="form-control" name="bank">
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" min="1">
                </div>
                <div class="form-group">
                    <label>Foto Bukti</label>
                    <input type="file" class="form-control" name="bukti">
                    <p class="text-danger">Foto bukti harus JPG maksimal 4MB</p>
                </div>
                <button class="btn btn-primary" name="kirim">Kirim</button>
            </form>
        </div>

        <?php
            //jika ada tombol kirim
            if(isset($_POST["kirim"]))
            {
                //UPLOAD DULU FOTO BUKTI
                $namabukti = $_FILES["bukti"]["name"];
                $lokasibukti = $_FILES["bukti"]["tmp_name"];
                $namafiks = date("YmdHis").$namabukti;
                move_uploaded_file($lokasibukti,"buktipembayaran/$namafiks");
            
                $nama = $_POST["nama"];
                $bank = $_POST["bank"];
                $jumlah = $_POST["jumlah"];
                $tanggal = date("Y-m-d");

                //SIMPAN PEMBAYARAN
                $koneksi->query("INSERT INTO pembayaran(id_pembelian,nama,bank,jumlah,tanggaL,bukti)
                VALUES ('$idpem','$nama','$bank','$jumlah','$tanggal','$namafiks') ");
                //update lah data pembeliannya dari pending menjadi sudah kirim pembayaran
                $koneksi->query("UPDATE pembelian SET status_pembelian='sudah kirim pembayaran'
                WHERE id_pembelian='$idpem'");

                echo "<script>alert('terimakasih sudah mengirimkan bukti pembayaran');</script>";
                echo "<script>location='riwayat.php';</script>";
            }
        ?>
</body>
</html>