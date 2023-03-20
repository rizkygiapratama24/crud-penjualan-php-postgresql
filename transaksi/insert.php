<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php
if (isset($_POST['simpan'])) {
    $barang_id = $_POST['barang_id'];
    $pembeli_id = $_POST['pembeli_id'];
    $kode_transaksi = $_POST['kode_transaksi'];
    $jumlah_transaksi = $_POST['jumlah_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    $query = "SELECT * FROM barang WHERE id_barang=?";
    $row = $link->prepare($query);
    $row->execute(array($barang_id));
    $data_stok = $row->fetch();

    $stok = $data_stok['stok'];

    // menghitung sisa stok barang
    $sisa_stok = (int) $stok - (int) $jumlah_transaksi;

    if ($stok < $jumlah_transaksi) {
        $msg = "Jumlah Barang Yang Di Transaksi kan Lebih Besar Dari Stok Barang";
        header("Location:insert.php?error=$msg");
    } else {
        $sql = 'INSERT INTO transaksi(barang_id,pembeli_id,kode_transaksi,jumlah_transaksi,tanggal_transaksi) VALUES(:barang_id,:pembeli_id,:kode_transaksi,:jumlah_transaksi,:tanggal_transaksi)';
        $stmt = $link->prepare($sql);

        $stmt->bindValue(':barang_id', $barang_id);
        $stmt->bindValue(':pembeli_id', $pembeli_id);
        $stmt->bindValue(':kode_transaksi', $kode_transaksi);
        $stmt->bindValue(':jumlah_transaksi', $jumlah_transaksi);
        $stmt->bindValue(':tanggal_transaksi', $tanggal_transaksi);

        $insert = $stmt->execute();

        if ($insert) {
            $msg = "Data Berhasil Disimpan";
            $data[] = $sisa_stok;
            $data[] = $barang_id;
            $update_stok = 'UPDATE barang SET stok=? WHERE id_barang=?';
            $stmt = $link->prepare($update_stok);

            $updatena = $stmt->execute($data);

            header("Location:index.php?msg=success&&pesan=$msg");
        }
    }

    // $sql = 'INSERT INTO transaksi(barang_id,pembeli_id,kode_transaksi,jumlah_transaksi,tanggal_transaksi) VALUES(:barang_id,:pembeli_id,:kode_transaksi,:jumlah_transaksi,:tanggal_transaksi)';
    // $stmt = $link->prepare($sql);

    // $stmt->bindValue(':barang_id', $barang_id);
    // $stmt->bindValue(':pembeli_id', $pembeli_id);
    // $stmt->bindValue(':kode_transaksi', $kode_transaksi);
    // $stmt->bindValue(':jumlah_transaksi', $jumlah_transaksi);
    // $stmt->bindValue(':tanggal_transaksi', $tanggal_transaksi);

    // $insert = $stmt->execute();

    // if ($insert) {
    //     $msg = "Data Berhasil Disimpan";
    //     // header("Location:index.php?msg=success&&pesan=$msg");
    // }
}

// ambil data transaksi dengan kode transaksi paling besar
$query = $link->query('SELECT MAX(kode_transaksi) as kodex FROM transaksi');
$data = $query->fetch();
$kode = $data['kodex']; // kode transaksi dengan angka terbesar
$nourut = substr($kode, 3, 4);
$nourut++;
$huruf = "TRK";
$kodeTransaksi = $huruf . sprintf("%03s", $nourut);
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Data Transaksi</h4>
        </div>
        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger" role="alert">
                <strong><?php echo $_GET['error']; ?></strong>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Tambah Transaksi</h5>
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
                                <input type="text" name="kode_transaksi" class="form-control" value="<?php echo $kodeTransaksi; ?>">
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
                                        <option value="<?php echo $barang['id_barang']; ?>"><?php echo $barang['nama_brg']; ?></option>
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
                                        <option value="<?php echo $pembeli['id_pembeli']; ?>"><?php echo $pembeli['nama_pembeli']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_transaksi" class="form-label">Jumlah Transaksi</label>
                                <input type="number" name="jumlah_transaksi" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control">
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