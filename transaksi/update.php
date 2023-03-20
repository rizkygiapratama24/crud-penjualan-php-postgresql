<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
$id_transaksi = $_GET['id_transaksi'];

$sql = 'SELECT * FROM transaksi WHERE id_transaksi=?';
$row = $link->prepare($sql);
$row->execute(array($id_transaksi));
$hasil = $row->fetch();

if (isset($_POST['edit'])) {
    $barang_id = $_POST['barang_id'];
    $pembeli_id = $_POST['pembeli_id'];
    $kode_transaksi = $_POST['kode_transaksi'];
    $jumlah_transaksi = $_POST['jumlah_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    $data[] = $barang_id;
    $data[] = $pembeli_id;
    $data[] = $kode_transaksi;
    $data[] = $jumlah_transaksi;
    $data[] = $tanggal_transaksi;
    $data[] = $id_transaksi;

    $sql = 'UPDATE transaksi SET barang_id=?, pembeli_id=?, kode_transaksi=?, jumlah_transaksi=?, tanggal_transaksi=? WHERE id_transaksi=?';
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
            <h4>Data Transaksi</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Transaksi</h5>
                <a href="index.php" class="btn btn-sm btn-primary">
                    Kembali Ke Data Transaksi
                </a>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
                                <input type="text" name="kode_transaksi" class="form-control" value="<?php echo $hasil['kode_transaksi']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="barang_id" class="form-label">Nama Barang</label>
                                <select name="barang_id" class="form-control">
                                    <option value="">-- PILIH NAMA BARANG --</option>
                                    <?php
                                    $sql = 'SELECT * FROM barang';
                                    $row = $link->prepare($sql);
                                    $row->execute();
                                    $barangs = $row->fetchAll();
                                    foreach ($barangs as $barang) {
                                    ?>
                                        <option value="<?php echo $barang['id_barang']; ?>" <?php if ($barang['id_barang'] == $hasil['barang_id']) echo "selected";  ?>><?php echo $barang['nama_brg']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pembeli_id" class="form-label">Nama Pembeli</label>
                                <select name="pembeli_id" class="form-control">
                                    <option value="">-- PILIH NAMA PEMBELI --</option>
                                    <?php
                                    $sql = 'SELECT * FROM pembeli';
                                    $row = $link->prepare($sql);
                                    $row->execute();
                                    $pembelis = $row->fetchAll();
                                    foreach ($pembelis as $pembeli) {
                                    ?>
                                        <option value="<?php echo $pembeli['id_pembeli']; ?>" <?php if ($pembeli['id_pembeli'] == $hasil['pembeli_id']) echo "selected"; ?>><?php echo $pembeli['nama_pembeli']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_transaksi" class="form-label">Jumlah Transaksi</label>
                                <input type="number" name="jumlah_transaksi" class="form-control" value="<?php echo $hasil['jumlah_transaksi']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control" value="<?php echo $hasil['tanggal_transaksi']; ?>">
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