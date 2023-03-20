<?php
$host = $_SERVER['HTTP_HOST'];
$hest = "http://" . $host . "/crud-penjualan-php-postgresql";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENJUALAN POSTGREESQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light pl-0">
            <div class="container">
                <a class="navbar-brand" href="#">PENJUALAN POSTGREESQL</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="<?php echo $hest; ?>/dashboard/" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $hest; ?>/barang/">Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $hest; ?>/supplier/">Supplier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $hest; ?>/pembeli/">Pembeli</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $hest; ?>/transaksi/">Transaksi</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="<?php echo $hest; ?>/logout.php" class="nav-link">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>