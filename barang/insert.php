<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_brg = $_POST['nama_brg'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $sql = 'INSERT INTO barang(kode_barang,nama_brg,harga,stok,supplier_id) VALUES(:kode_barang,:nama_brg,:harga,:stok,:supplier_id)';
    $stmt = $link->prepare($sql);

    $stmt->bindValue(':kode_barang', $kode_barang);
    $stmt->bindValue(':nama_brg', $nama_brg);
    $stmt->bindValue(':harga', $harga);
    $stmt->bindValue(':stok', $stok);
    $stmt->bindValue(':supplier_id', $supplier_id);

    $insert = $stmt->execute();

    if ($insert) {
        $msg = "Data Berhasil Disimpan";
        header("Location:index.php?msg=success&&pesan=$msg");
    }
}

// ambil data barang dengan kode barang paling besar
$query = $link->query('SELECT MAX(kode_barang) as kodex FROM barang');
$data = $query->fetch();
$kode = $data['kodex']; // kode barang dengan angka terbesar
$nourut = substr($kode, 3, 4);
$nourut++;
$huruf = "BR";
$kodeBarang = $huruf . sprintf("%02s", $nourut);
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Barang</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Tambah Barang</h5>
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
                                <input type="text" name="kode_barang" class="form-control" value="<?php echo $kodeBarang; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_brg" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_brg" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga Barang</label>
                                <input type="number" name="harga" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stok" class="form-label">Stok Barang</label>
                                <input type="number" name="stok" class="form-control">
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
                                        <option value="<?php echo $supplier['id_supplier'] ?>"><?php echo $supplier['nama_supplier']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
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