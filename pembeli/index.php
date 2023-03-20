<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (!empty($_GET['id_pembeli'])) {
    $id_pembeli = $_GET['id_pembeli'];

    $sql = 'DELETE FROM pembeli WHERE id_pembeli=?';
    $row = $link->prepare($sql);
    $row->execute(array($id_pembeli));

    $msg = "Data Berhasil Dihapus";
    header("Location:index.php?msg=success&&pesan=$msg");
}

if (isset($_POST['hapusall'])) {
    $chk_id = $_POST['chk_id'];

    foreach ($chk_id as $chk) {
        $query_all = 'DELETE FROM pembeli WHERE id_pembeli=?';
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
            <h4>Data Pembeli</h4>
        </div>
        <?php if (!empty($_GET['msg'])) : ?>
            <div class="alert alert-success" role="alert">
                <strong><?php echo $_GET['pesan']; ?></strong>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    <a href="insert.php" class="btn btn-sm btn-primary">Tambah Pembeli</a>
                    <button type="submit" name="hapusall" class="btn btn-sm btn-danger hapus-terpilih disabled" onclick="return confirm('Yakin Ingin Dihapus ?')">Hapus</button>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="chk_all" id="chk_all"> </th>
                                <th>NO</th>
                                <th>NAMA PEMBELI</th>
                                <th>NO. TELEPON</th>
                                <th>ALAMAT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = 'SELECT * FROM pembeli ORDER BY id_pembeli ASC';
                            $row = $link->prepare($sql);
                            $row->execute();
                            $pembelis = $row->fetchAll();
                            $no = 1;
                            foreach ($pembelis as $pembeli) {
                            ?>
                                <tr>
                                    <td> <input type="checkbox" name="chk_id[]" id="chk_id" value="<?php echo $pembeli['id_pembeli']; ?>"> </td>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $pembeli['nama_pembeli']; ?></td>
                                    <td><?php echo $pembeli['no_tlp_pembeli']; ?></td>
                                    <td><?php echo $pembeli['alamat_pembeli']; ?></td>
                                    <td>
                                        <a href="update.php?id_pembeli=<?php echo $pembeli['id_pembeli']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="index.php?id_pembeli=<?php echo $pembeli['id_pembeli']; ?>" onclick="return confirm('Yakin Ingin Dihapus ?')" class="btn btn-sm btn-danger">Hapus</a>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>

</html>