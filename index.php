<?php
require_once('koneksi.php');
session_start();
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'SELECT * FROM users WHERE username= :username AND password= :password';
    $stmt = $link->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $cek = $stmt->rowCount();

    if ($cek > 0) {
        $data = $stmt->fetch();
        $_SESSION['username'] = $data['username'];
        $_SESSION['logged-in'] = "logged-in";
        header('Location:dashboard');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENJUALAN POSTGREESQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="mt-5 mb-5">
            <div class="card w-50 m-auto">
                <div class="card-body">
                    <div class="title mb-3 text-center">
                        <h4>LOGIN PENJUALAN POSTGREESQL</h4>
                    </div>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" name="login" class="btn btn-sm btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>