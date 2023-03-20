<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
$id_pembeli = $_GET['id_pembeli'];

$sql = 'SELECT * FROM pembeli WHERE id_pembeli=?';
$row = $link->prepare($sql);
$row->execute(array($id_pembeli));
$hasil = $row->fetch();

if (isset($_POST['edit'])) {

    $nama_pembeli = $_POST['nama_pembeli'];
    $no_tlp_pembeli = $_POST['no_tlp_pembeli'];
    $alamat_pembeli = $_POST['alamat_pembeli'];

    $data[] = $nama_pembeli;
    $data[] = $no_tlp_pembeli;
    $data[] = $alamat_pembeli;
    $data[] = $id_pembeli;

    $sql = 'UPDATE pembeli SET nama_pembeli=?, no_tlp_pembeli=?, alamat_pembeli=? WHERE id_pembeli=?';
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
            <h4>Data pembeli</h4>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit pembeli</h5>
                <a href="index.php" class="btn btn-sm btn-primary">
                    Kembali Ke Data pembeli
                </a>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" class="form-control" value="<?php echo $hasil['nama_pembeli']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_tlp_pembeli" class="form-label">No. Telepon Pembeli</label>
                                <input type="text" name="no_tlp_pembeli" class="form-control" value="<?php echo $hasil['no_tlp_pembeli']; ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat_pembeli" class="form-label">Alamat Pembeli</label>
                                <textarea name="alamat_pembeli" cols="30" rows="10" class="form-control"><?php echo $hasil['alamat_pembeli']; ?></textarea>
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