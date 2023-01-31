<?php
session_start();
include_once("../connection.php");
// check login
if (!$_SESSION['status']) {
    header("Location:http://localhost:8080//PWD/TA/login.php");
    die;
}
$sql = "SELECT * FROM logs ORDER BY time_edit DESC";
$run = mysqli_query($conn, $sql);
$no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>pwd</title>
    <link rel="stylesheet" href="https://kit.fontawesome.com/8ed166d714.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/Footer-Clean-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../assets/css/Simple-Slider-Simple-Slider.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />


</head>

<body>
    <header>
        <nav class="navbar navbar-light navbar-expand-md navwhite">
            <div class="container">
                <div class="navbar-brand">
                    <h3>Welcome, <?= $_SESSION['username'] ?></h3>
                </div>
                <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                    <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="gallery-admin.php">Gallery</a></li>
                        <li class="nav-item">
                            <a class="nav-link active" href="logs.php">Logs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('Apakah anda yakin ingin logout ?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Logs Edit Content</h2>
        <div class="m-3 text-end">
            <a href="cetak_logs.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Download Logs
            </a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">User</th>
                    <th scope="col">Tabel</th>
                    <th scope="col">Action</th>
                    <th scope="col">Time Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r = mysqli_fetch_array($run)) : ?>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $r['user'] ?></td>
                        <td><?= $r['tabel'] ?></td>
                        <td><?= $r['action'] ?></td>
                        <td><?= $r['time_edit'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="../assets/js/Simple-Slider.js"></script>
    <script src="https://kit.fontawesome.com/8ed166d714.js" crossorigin="anonymous"></script>
</body>

</html>