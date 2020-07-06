<h2>Ubah Produk</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

echo "<pre>";
print_r($pecah);
echo "</pre>";
?>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Produk</label>
        <input type="text" name="nama" class="form-control"
        value="<?php echo $pecah['nama_produk']; ?>">
    </div>
    <div class="form-group">
        <label>Harga(Rp)</label>
        <input type="text" name="harga" class="form-control">
    </div>
    <div class="form-group">
        <img src="../fotoproduk/<?php echo $pecah['foto_produk'] ?>" width="200">
    </div>
    <div class="form-group">
        <label>Ganti Foto</label>
        <input type="file" name="foto" class="form-control">
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="10">
            <?php echo $pecah['deskripsi_produk']; ?>
        </textarea>
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
    if(isset($_POST['ubah']))
    {
        $namafoto = $_FILES['foto']['name'];
        $lokasifoto = $_FILES['foto']['tmp_name'];
        //jika foto dirubah
        if(!empty($lokasifoto))
        {
            move_uploaded_file($lokasifoto, "../fotoproduk/$namafoto");

            $koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]',
                harga_produk='$_POST[harga]',foto_produk='$namafoto',
                deskripsi_produk='$_POST[deskripsi]' WHERE id_produk='$_GET[id]'");
        }
        else
        {
            $koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]',
                harga_produk='$_POST[harga]', deskripsi_produk='$_POST[deskripsi]'
                WHERE id_produk='$_GET[id]'");
        }
        echo "<script>alert('data produk telah diubah');</script>";
        echo "<script>location='index.php?halaman=produk';</script>";
    }
?>