<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location:../index.php');
}
require_once('../koneksi.php');
?>
<?php include "../assets/layouts/top.php"; ?>
<div class="container dashboard">
    <div class="mt-4 mb-5">
        <div class="title mb-3">
            <h4>Dashboard</h4>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Diagram Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Data Barang Dengan Stok Menipis & Habis</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA BARANG</th>
                                    <th>STOK</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = 'SELECT nama_brg,stok FROM barang WHERE stok <= ?';
                                $jumlah = $link->prepare($sql);
                                $jumlah->execute([5]);
                                $jumlahbrg = $jumlah->fetchAll();
                                $no = 1;
                                ?>
                                <?php if ($jumlahbrg) : ?>
                                    <?php foreach ($jumlahbrg as $jumlah) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $jumlah['nama_brg']; ?></td>
                                            <td><?php echo $jumlah['stok']; ?></td>
                                            <td>
                                                <?php
                                                if ($jumlah['stok'] == 0) {
                                                    echo "Habis";
                                                } elseif ($jumlah['stok'] <= 5) {
                                                    echo "Menipis";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../assets/layouts/bottom.php"; ?>
<?php
$sql = "SELECT TO_CHAR(tanggal_transaksi, 'Mon') AS bulan, SUM(jumlah_transaksi) AS total FROM transaksi GROUP BY TO_CHAR(tanggal_transaksi, 'Mon') ORDER BY TO_CHAR(tanggal_transaksi, 'Mon') ASC";
$stmt = $link->prepare($sql);
$stmt->execute();

$row = $stmt->fetchAll();

foreach ($row as $bulan) {
    $categories[] = $bulan['bulan'];
    $data[] = $bulan['total'];
}
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Laporan Penjualan Barang Per Bulan'
        },
        subtitle: {
            text: 'Berdasarkan Jumlah Barang'
        },
        xAxis: {
            categories: <?php echo json_encode($categories); ?>,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Total',
            data: <?php echo json_encode($data); ?>
        }]
    });
</script>
</body>

</html>