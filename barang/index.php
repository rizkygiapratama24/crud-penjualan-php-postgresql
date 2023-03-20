<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
include "../function_format/format-rupiah.php";
?>
<?php
if (!empty($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    $sql = 'DELETE FROM barang WHERE id_barang=?';
    $row = $link->prepare($sql);
    $row->execute(array($id_barang));

    $msg = "Data Berhasil Dihapus";
    header("Location:index.php?msg=success&&pesan=$msg");
}

if (isset($_POST['hapusall'])) {
    $chk_id = $_POST['chk_id'];

    foreach ($chk_id as $chk) {
        $query_all = 'DELETE FROM barang WHERE id_barang=?';
        $stmt = $link->prepare($query_all);
        $stmt->execute([$chk]);
    }

    $msg = "Data Berhasil Dihapus";
    header("Location:index.php?msg=success&&pesan=$msg");
}
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Barang</h4>
        </div>
        <?php if (!empty($_GET['msg'])) : ?>
            <div class="alert alert-success" role="alert">
                <strong><?php echo $_GET['pesan']; ?></strong>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    <a href="insert.php" class="btn btn-sm btn-primary">Tambah Barang</a>
                    <button type="submit" name="hapusall" class="btn btn-sm btn-danger hapus-terpilih disabled" onclick="return confirm('Yakin Ingin Dihapus ?')">Hapus</button>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="chk_all" id="chk_all"> </th>
                                <th>NO</th>
                                <th>KODE BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>HARGA</th>
                                <th>STOK</th>
                                <th>SUPPLIER</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = 'SELECT * FROM barang b INNER JOIN supplier s ON s.id_supplier = b.supplier_id ORDER BY b.kode_barang ASC';
                            $row = $link->prepare($sql);
                            $row->execute();
                            $barangs = $row->fetchAll();
                            $no = 1;
                            foreach ($barangs as $barang) {
                            ?>
                                <tr>
                                    <td> <input type="checkbox" name="chk_id[]" id="chk_id" value="<?php echo $barang['id_barang']; ?>"> </td>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $barang['kode_barang']; ?></td>
                                    <td><?php echo $barang['nama_brg']; ?></td>
                                    <td><?php echo rupiah($barang['harga']); ?></td>
                                    <td><?php echo $barang['stok']; ?></td>
                                    <td><?php echo $barang['nama_supplier']; ?></td>
                                    <td>
                                        <a href="update.php?id_barang=<?php echo $barang['id_barang']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="index.php?id_barang=<?php echo $barang['id_barang']; ?>" onclick="return confirm('Yakin Ingin Dihapus ?')" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php
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