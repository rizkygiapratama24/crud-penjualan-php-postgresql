<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (!empty($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $jumlah_transaksi = $_GET['jumlah_transaksi'];
    $barang_id = $_GET['barang_id'];

    $sql = 'DELETE FROM transaksi WHERE id_transaksi=?';
    $row = $link->prepare($sql);
    $hapusna = $row->execute(array($id_transaksi));

    if ($hapusna) {
        $msg = "Data Berhasil Dihapus";
        $stok_batal = "UPDATE barang SET stok=(stok+'$jumlah_transaksi') WHERE id_barang=?";
        $stmt = $link->prepare($stok_batal);
        $stmt->execute(array($barang_id));
        header("Location:index.php?msg=success&&pesan=$msg");
    }
}

if (isset($_POST['hapusall'])) {
    $chk_id = $_POST['chk_id'];
    $barang_idna = $_POST['barang_id'];
    $jumlah_transaksi = $_POST['jumlah_transaksi'];

    foreach ($chk_id as $chk) {
        $query_all = 'DELETE FROM transaksi WHERE id_transaksi=?';
        $stmt = $link->prepare($query_all);
        $stmt->execute([$chk]);

        if ($stmt->execute([$chk])) {
            $msg = "Data Berhasil Dihapus";
            header("Location:index.php?msg=success&&pesan=$msg");
        }
    }
}
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container dashboard">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Transaksi</h4>
        </div>
        <?php if (!empty($_GET['msg'])) : ?>
            <div class="alert alert-success" role="alert">
                <strong><?php echo $_GET['pesan']; ?></strong>
            </div>
        <?php endif; ?>

        <form action="" method="get" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_transaksi" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_transaksi" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div>
                            <label for="" class="form-label opacity-0">Cari : </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Cari Tanggal Transaksi</button>
                    </div>
                </div>
            </div>
        </form>

        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    <a href="insert.php" class="btn btn-sm btn-primary">Tambah Transaksi</a>
                    <button type="submit" name="hapusall" class="btn btn-sm btn-danger hapus-terpilih disabled">Hapus</button>
                    <a href="index.php" class="btn btn-sm btn-primary">Reload</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="chk_all" id="chk_all"> </th>
                                <th>NO</th>
                                <th>KODE TRANSAKSI</th>
                                <th>NAMA BARANG</th>
                                <th>NAMA PEMBELI</th>
                                <th>JUMLAH TRANSAKSI</th>
                                <th>TANGGAL TRANSAKSI</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (isset($_GET['start']) && isset($_GET['end'])) {
                                $sql = 'SELECT * FROM transaksi t INNER JOIN barang b ON b.id_barang = t.barang_id INNER JOIN pembeli p ON p.id_pembeli = t.pembeli_id WHERE t.tanggal_transaksi BETWEEN ? AND ?';
                                $row = $link->prepare($sql);
                                $row->execute(array($_GET['start'], $_GET['end']));
                                $transaksis = $row->fetchAll();
                                $no = 1;

                                if ($row->rowCount() > 0) {
                                    foreach ($transaksis as $transaksi) {
                            ?>
                                        <tr>
                                            <td> <input type="checkbox" name="chk_id[]" id="chk_id" value="<?php echo $transaksi['id_transaksi']; ?>"> </td>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $transaksi['kode_transaksi']; ?></td>
                                            <td>
                                                <?php echo $transaksi['nama_brg']; ?>
                                                <input type="hidden" name="barang_id[]" value="<?php echo $transaksi['barang_id']; ?>">
                                            </td>
                                            <td><?php echo $transaksi['nama_pembeli']; ?></td>
                                            <td>
                                                <?php echo $transaksi['jumlah_transaksi']; ?>
                                                <input type="hidden" name="jumlah_transaksi[]" value="<?php echo $transaksi['jumlah_transaksi']; ?>">
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                                            <td>
                                                <a href="update.php?id_transaksi=<?php echo $transaksi['id_transaksi']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="index.php?id_transaksi=<?php echo $transaksi['id_transaksi']; ?>&barang_id=<?php echo $transaksi['barang_id']; ?>&jumlah_transaksi=<?php echo $transaksi['jumlah_transaksi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Ingin Dihapus ?');">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                            } else {
                                $sql = 'SELECT * FROM transaksi t INNER JOIN barang b ON b.id_barang = t.barang_id INNER JOIN pembeli p ON p.id_pembeli = t.pembeli_id';
                                $row = $link->prepare($sql);
                                $row->execute();
                                $transaksis = $row->fetchAll();
                                $no = 1;
                                foreach ($transaksis as $transaksi) {
                                    ?>
                                    <tr>
                                        <td> <input type="checkbox" name="chk_id[]" id="chk_id" value="<?php echo $transaksi['id_transaksi']; ?>"> </td>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $transaksi['kode_transaksi']; ?></td>
                                        <td><?php echo $transaksi['nama_brg']; ?></td>
                                        <td><?php echo $transaksi['nama_pembeli']; ?></td>
                                        <td><?php echo $transaksi['jumlah_transaksi']; ?></td>
                                        <td><?php echo date('d M Y', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                                        <td>
                                            <a href="update.php?id_transaksi=<?php echo $transaksi['id_transaksi']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="index.php?id_transaksi=<?php echo $transaksi['id_transaksi']; ?>&barang_id=<?php echo $transaksi['barang_id']; ?>&jumlah_transaksi=<?php echo $transaksi['jumlah_transaksi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Ingin Dihapus ?');">Hapus</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "../assets/layouts/bottom.php"; ?>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>

</html>