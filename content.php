<?php

if (!$_GET['title']) {
    header("location: index.php");
    die;
}

include_once "connection.php";

$url = $_GET["title"];
$title = str_replace("-", " ", $url);
$sql = "SELECT * FROM artikel WHERE title = '$title'";
$result = mysqli_query($conn, $sql);
$r = mysqli_fetch_array($result);
$id = $r['id']; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Candi | <?= $title ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/Footer-Clean-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/Simple-Slider-Simple-Slider.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<body>
    <nav id="autohide" class="navbar navbar-expand-md navbar-light navwhite">
        <div class="container">
            <a class="navbar-brand" href="#">Wisata Candi</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="photo-gallery py-4 py-xl-5">
        <div class="container-fluid p-0">
            <div class="row g-0 mb-2">
                <div class="col-xl-10 col-sm-9 text-center mx-auto">
                    <h2><?= $r['title'] ?></h2>
                    <p class="w-lg-50"><?= $r['content'] ?></p>
                </div>
            </div>
            <div class="row g-0 row-cols-1 row-cols-md-2 row-cols-xl-3 photos mb-5" data-bss-baguettebox>
                <?php
                $sql_image = "SELECT * FROM image INNER JOIN artikel
                ON artikel.id = image.id_artikel
                WHERE image.id_artikel = '$id'";
                $res_image = mysqli_query($conn,  $sql_image);
                if (mysqli_num_rows($res_image) > 0) :
                    while ($images = mysqli_fetch_assoc($res_image)) : ?>
                        <div class="col item">
                            <a href="uploads/<?= $images["image"] ?>">
                                <img class="img-fluid" src="uploads/<?= $images["image"] ?>" />
                            </a>
                        </div>
                <?php
                    endwhile;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/navbar-transparent.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
    <script src="assets/js/autohide-nav.js"></script>
</body>

</html>