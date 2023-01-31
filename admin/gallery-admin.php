<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>pwd</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/Footer-Clean-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../assets/css/Simple-Slider-Simple-Slider.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
</head>

<body>
    <?php
    session_start();

    if (!$_SESSION['status']) {
        header("location:../login.php");
        die;
    }

    include "../connection.php";

    // Delete image
    if (isset($_POST['delete_image_btn'])) { //untuk check tombol delete di tekan

        $id = $_POST['delete_id'];
        $delete_image = $_POST['delete_image'];
        $path = "../uploads/" . $delete_image;
        $user = $_SESSION['username'];
        date_default_timezone_set("ASIA/JAKARTA");
        $tanggal = date("Y-m-d H:i:s");

        $sql_select = "SELECT * FROM image WHERE id = '$id'";
        $result = mysqli_fetch_array(mysqli_query($conn, $sql_select));
        $id_artikel = $result['id_artikel'];
        $sql_select2 = "SELECT * FROM artikel WHERE id = '$id_artikel'";
        $result2 = mysqli_fetch_array(mysqli_query($conn, $sql_select2));
        $title = $result2['title'];
        $content = $result2['content'];

        $query = "DELETE FROM image WHERE id = '$id'"; //sql hapus image
        mysqli_query($conn, $query);
        $sql2 = "INSERT INTO logs(user,tabel,action,time_edit) VALUES ('$user','image', 'DELETE', '$tanggal')";
        mysqli_query($conn, $sql2);
        $sql3 = "UPDATE artikel SET author = '$user',title = '$title', content = '$content' WHERE id = $id_artikel";
        mysqli_query($conn, $sql3);
        unlink($path);
    }
    ?>

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
                        <li class="nav-item">
                            <a class="nav-link active" href="gallery-admin.php">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logs.php">Logs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('Apakah anda yakin ingin logout ?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Form input gambar -->
    <div class="container mt-4">
        <?php
        if (isset($_GET['error'])) {
            $error = urldecode($_GET['error']);
            echo "<p style='color: red;'>" . $error . "</p>";
        }

        //untuk kategori foto candi
        $sql = "SELECT * FROM artikel";
        $result = mysqli_query($conn, $sql);
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <label for="candi_image" class="form-label">Input Gambar</label>
                <div class="col-md-6 p-2">
                    <select class="form-select" name="nama_candi" id="candi_image">
                        <?php while ($r = mysqli_fetch_array($result)) : ?>
                            <option><?= $r['title'] ?></option>;
                        <?php endwhile ?>
                    </select>
                </div>
                <div class="col-md-6 p-2">
                    <input type="file" class="form-control" name="gambar">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit" name="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    $sql = "SELECT * FROM artikel";
    $result = mysqli_query($conn, $sql);
    while ($r = mysqli_fetch_array($result)) :
        $title = $r['title']; ?>
        <section class="p-5">
            <div class="container-fluid d-flex flex-column align-items-center py-4 py-xl-5">
                <div class="row gy-4 row-cols-1 row-cols-md-2 w-100" style="max-width: 1150px">
                    <?php
                    $sql_image = "SELECT *, image.id as id_image FROM image INNER JOIN artikel
                                    ON artikel.id = image.id_artikel
                                    WHERE artikel.title = '$title'";
                    $res = mysqli_query($conn,  $sql_image);

                    if (mysqli_num_rows($res) > 0) :
                        while ($images = mysqli_fetch_assoc($res)) : ?>
                            <div class="col order-md-2">
                                <div class="card">
                                    <img class="card-img w-100 d-block" src="../uploads/<?= $images["image"] ?>" />
                                    <div class="card-img-overlay text-center d-flex flex-column justify-content-center align-items-center p-4">
                                        <form action="" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $images['id_image']; ?>">
                                            <input type="hidden" name="delete_image" value="<?php echo $images['image']; ?>">
                                            <button type="submit" name="delete_image_btn" class="btn btn-danger button" onclick="return confirm('Apakah anda yakin ingin menghapus gambar ini ?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ?>
                        <div class="col d-md-flex order-first justify-content-md-start align-items-md-center order-md-1">
                            <div style="width: 80%">
                                <h2><?= $title ?></h2>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12">
                            <h2 class="text-center">Photo <?= $title ?> Kosong</h2>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </section>
    <?php endwhile ?>

    <!-- Java Script -->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
</body>

</html>