<?php


include_once "connection.php";

$sql = "SELECT * FROM artikel";
$result = mysqli_query($conn, $sql);
$check = mysqli_num_rows($result); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Blog</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/Footer-Clean-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/Simple-Slider-Simple-Slider.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<body>
    <header class="text-bg-light">
        <nav class="navbar navbar-light navbar-expand-md navwhite">
            <div class="container">
                <a class="navbar-brand" href="index.php">Wisata Candi</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                    <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="blog.php">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container" style="padding-top: 40px; padding-bottom: 40px">
        <?php if ($check > 0) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php while ($r = mysqli_fetch_array($result)) :
                    $title = $r['title']; ?>
                    <div class="col">
                        <div class="card h-100">
                            <?php
                            $sql_image = "SELECT * FROM image INNER JOIN artikel
                                                ON artikel.id = image.id_artikel
                                                WHERE artikel.title = '$title' LIMIT 1";
                            $res_image = mysqli_query($conn,  $sql_image);
                            $images = mysqli_fetch_assoc($res_image);
                            if (mysqli_num_rows($res_image) > 0) : ?>
                                <div class="inner">
                                    <img src="uploads/<?= $images['image'] ?>" class="card-img-top" alt="...">
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= $r['title'] ?></h5>
                                <p class="card-text"><?= substr($r['content'], 0, 150) ?>[...]</p>
                                <a href="content.php?title=<?= str_replace(" ", "-", $r['title'])  ?>" class="btn btn-outline-info"><i class="fas fa-link"></i>View More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <h2 class="text-center mt-4">Data Tidak Ditemukan</h2>
        <?php endif ?>

    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
    <script src="assets/js/validationlogin.js"></script>
</body>

</html>