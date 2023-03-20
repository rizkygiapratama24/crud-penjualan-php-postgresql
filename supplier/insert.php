<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (isset($_POST['simpan'])) {
    $nama_supplier = $_POST['nama_supplier'];
    $no_tlp_supplier = $_POST['no_tlp_supplier'];
    $email_supplier = $_POST['email_supplier'];
    $alamat_supplier = $_POST['alamat_supplier'];

    $sql = 'INSERT INTO supplier(nama_supplier,no_tlp_supplier,email_supplier,alamat_supplier) VALUES(:nama_supplier,:no_tlp_supplier,:email_supplier,:alamat_supplier)';
    $stmt = $link->prepare($sql);

    $stmt->bindValue(':nama_supplier', $nama_supplier);
    $stmt->bindValue(':no_tlp_supplier', $no_tlp_supplier);
    $stmt->bindValue(':email_supplier', $email_supplier);
    $stmt->bindValue(':alamat_supplier', $alamat_supplier);

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
            <h4>Data Supplier</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Tambah Supplier</h5>
                <a href="index.php" class="btn btn-sm btn-primary">
                    Kembali Ke Data Supplier
                </a>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                <input type="text" name="nama_supplier" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_tlp_supplier" class="form-label">No. Telepon Supplier</label>
                                <input type="text" name="no_tlp_supplier" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email_supplier" class="form-label">Email Supplier</label>
                                <input type="email" name="email_supplier" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat_supplier" class="form-label">Alamat Supplier</label>
                                <textarea name="alamat_supplier" cols="30" rows="10" class="form-control"></textarea>
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