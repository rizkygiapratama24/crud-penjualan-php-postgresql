<?php
require_once('../koneksi.php');
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
?>
<?php
$id_barang = $_GET['id_barang'];

$sql = 'SELECT * FROM barang WHERE id_barang=?';
$row = $link->prepare($sql);
$row->execute(array($id_barang));
$hasil = $row->fetch();

if (isset($_POST['edit'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_brg = $_POST['nama_brg'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $data[] = $kode_barang;
    $data[] = $nama_brg;
    $data[] = $harga;
    $data[] = $stok;
    $data[] = $supplier_id;
    $data[] = $id_barang;

    $sql = 'UPDATE barang SET kode_barang=?, nama_brg=?, harga=?, stok=?, supplier_id=? WHERE id_barang=?';
    $stmt = $link->prepare($sql);

    $update = $stmt->execute($data);

    if ($update) {
        $msg = "Data Berhasil Di Edit";
        header("Location:index.php?msg=success&&pesan=$msg");
    }
}
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Barang</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Barang</h5>
                <a href="index.php" class="btn btn-sm btn-primary">
                    Kembali Ke Data Barang
                </a>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" class="form-control" value="<?php echo $hasil['kode_barang']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_brg" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_brg" class="form-control" value="<?php echo $hasil['nama_brg']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga Barang</label>
                                <input type="text" name="harga" class="form-control" value="<?php echo $hasil['harga']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stok" class="form-label">Stok Barang</label>
                                <input type="text" name="stok" class="form-control" value="<?php echo $hasil['stok']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier_id" class="form-label">Nama Supplier</label>
                                <select name="supplier_id" class="form-control">
                                    <option value="">-- PILIH SUPPLIER --</option>
                                    <?php
                                    $sql = 'SELECT * FROM supplier';
                                    $stmt = $link->prepare($sql);
                                    $stmt->execute();
                                    $suppliers = $stmt->fetchAll();
                                    foreach ($suppliers as $supplier) {
                                    ?>
                                        <option value="<?php echo $supplier['id_supplier'] ?>" <?php if ($supplier['id_supplier'] == $hasil['supplier_id']) echo "selected"; ?>><?php echo $supplier['nama_supplier']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../assets/layouts/bottom.php"; ?>
</body>

</html>