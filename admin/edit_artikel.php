<?php
session_start();
include_once("../connection.php");
// check login
if (!$_SESSION['status']) {
    header("Location:http://localhost:8080//PWD/TA/login.php");
    die;
}

if (!$_GET['id']) {
    header("Location:http://localhost:8080//PWD/TA/admin/index.php");
    die;
}

$id = $_GET['id'];

if (isset($_POST['btn_delete'])) {
    $sql = "SELECT * FROM image WHERE id_artikel = $id";
    $run = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($run);
    $author = $_SESSION['username'];
    date_default_timezone_set("ASIA/JAKARTA");
    $tanggal = date("Y-m-d H:i:s");

    // Delete image
    if ($check > 0) {
        while ($r = mysqli_fetch_array($run)) {
            $path = "../uploads/" . $r['image'];
            unlink($path);
        }
        $query = "DELETE FROM image WHERE id_artikel = $id";
        $query_run = mysqli_query($conn, $query);
    }
    $sql2 = "DELETE FROM artikel WHERE id = $id";
    mysqli_query($conn, $sql2);
    $sql2 = "INSERT INTO logs(user,tabel,action,time_edit) VALUES ('$author','artikel', 'DELETE', '$tanggal')";
    mysqli_query($conn, $sql2);
    mysqli_close($conn);
    header("Location:http://localhost:8080//PWD/TA/admin/index.php");
}

if (isset($_POST['Submit_update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];
    date_default_timezone_set("ASIA/JAKARTA");
    $tanggal = date("Y-m-d H:i:s");

    $sql = "UPDATE artikel SET author = '$author',title = '$title', content = '$content' WHERE id = $id";
    $sql2 = "INSERT INTO logs(user,tabel,action,time_edit) VALUES ('$author','artikel', 'UPDATE', '$tanggal')";
    if ($title != "" && $content != "") {
        mysqli_query($conn, $sql);
        mysqli_query($conn, $sql2);
        header("Location:http://localhost:8080//PWD/TA/admin/edit_artikel.php?id=$id");
    } else {
        echo '<script>window.alert("Data tidak boleh kosong!")</script>';
    }
}
?>
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

    <?php
    $sql = "SELECT * FROM artikel WHERE id = '$id'";
    $res = mysqli_query($conn,  $sql);
    $r = mysqli_fetch_array($res);
    $title = $r['title']; ?>
    <div class=" container">
        <?php
        if (isset($_POST['btn_editart'])) : ?>
            <div class="mb-3 mt-5 mb-5">
                <h2 class="text-center">Edit Content</h2>
                <form action="" method="post">
                    <div class="row">
                        <label for="candi_image" class="form-label">Judul Content</label>
                        <div class="col-md-12 p-2">
                            <input type="text" class="form-control" name="title" value="<?= $r['title'] ?>">
                        </div>
                        <label for="floatingTextarea">Isi Content</label>
                        <div class="col-md-12 p-2">
                            <textarea class="form-control" id="floatingTextarea" name="content"><?= $r['content'] ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="Submit_update">Submit</button>
                            <a href="edit_artikel.php?id=<?= $id ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>

        <?php else : ?>
            <section class="photo-gallery py-4 py-xl-5">
                <div class="container-fluid p-0">
                    <div class="row g-0 mb-2">
                        <div class="col-xl-10 col-sm-9 text-center mx-auto">
                            <h2><?= $r['title'] ?></h2>
                            <p class="w-lg-50"><?= $r['content'] ?></p>
                        </div>
                    </div>
                    <div class="row g-0 row-cols-1 row-cols-md-2 row-cols-xl-3 photos" data-bss-baguettebox>
                        <?php
                        $sql_image = "SELECT * FROM image INNER JOIN artikel
                                    ON artikel.id = image.id_artikel
                                    WHERE image.id_artikel = '$id'";
                        $res_image = mysqli_query($conn,  $sql_image);
                        if (mysqli_num_rows($res_image) > 0) :
                            while ($images = mysqli_fetch_assoc($res_image)) : ?>
                                <div class="col item inner">
                                    <a href="../uploads/<?= $images["image"] ?>">
                                        <img class="img-fluid" src="../uploads/<?= $images["image"] ?>" />
                                    </a>
                                </div>
                        <?php
                            endwhile;
                        endif; ?>
                    </div>
                </div>
            </section>
            <div class="mb-3 mt-2 mb-5 text-center">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button class="btn btn-outline-primary" name="btn_editart">Edit Content</button>
                    <button class="btn btn-danger" name="btn_delete" onclick="return confirm('Apakah anda yakin ingin menghapus content ini ?')">Delete Content</button>
                </form>
            </div>
        <?php endif ?>
    </div>



    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="../assets/js/Simple-Slider.js"></script>
</body>

</html>