<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (isset($_POST['simpan'])) {
    $nama_pembeli = $_POST['nama_pembeli'];
    $no_tlp_pembeli = $_POST['no_tlp_pembeli'];
    $alamat_pembeli = $_POST['alamat_pembeli'];

    $sql = 'INSERT INTO pembeli(nama_pembeli,no_tlp_pembeli,alamat_pembeli) VALUES(:nama_pembeli,:no_tlp_pembeli,:alamat_pembeli)';
    $stmt = $link->prepare($sql);

    $stmt->bindValue(':nama_pembeli', $nama_pembeli);
    $stmt->bindValue(':no_tlp_pembeli', $no_tlp_pembeli);
    $stmt->bindValue(':alamat_pembeli', $alamat_pembeli);

    $insert = $stmt->execute();

    if ($insert) {
        $msg = "Data Berhasil Disimpan";
        header("Location:index.php?msg=success&&pesan=$msg");
    }
}
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Pembeli</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Tambah Pembeli</h5>
                <a href="index.php" class="btn btn-sm btn-primary">
                    Kembali Ke Data Pembeli
                </a>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_tlp_pembeli" class="form-label">No. Telepon Pembeli</label>
                                <input type="text" name="no_tlp_pembeli" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat_pembeli" class="form-label">Alamat Pembeli</label>
                                <textarea name="alamat_pembeli" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="simpan" class="btn btn-sm btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../assets/layouts/bottom.php"; ?>
</body>

</html>