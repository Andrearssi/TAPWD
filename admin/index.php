<?php
session_start();
include_once("../connection.php");
// check login
if (!$_SESSION['status']) {
    header("Location:http://localhost:8080//PWD/TA/login.php");
    die;
}

if (isset($_POST['Submit_content'])) { //check kalau submit content
    //mengambil nilai dari form
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];
    date_default_timezone_set("ASIA/JAKARTA");
    $tanggal = date("Y-m-d H:i:s");

    //create content
    $sql = "INSERT INTO artikel(author,title,content) VALUES ('$author','$title', '$content')";
    if ($title != "" && $content != "") { //check kalau data tidak kosong / null
        $sql_sel = "SELECT * FROM artikel WHERE title = '$title'";
        $check = mysqli_num_rows(mysqli_query($conn, $sql_sel));
        if ($check > 0) {
            echo '<script>window.alert("Judul Content Sudah Ada")
                    window.location = "index.php"</script>';
            die;
        }
        $run = mysqli_query($conn, $sql);
        //logs
        $sql2 = "INSERT INTO logs(user,tabel,action,time_edit) VALUES ('$author','artikel', 'CREATE', '$tanggal')";
        $run2 = mysqli_query($conn, $sql2);
    } else {
        echo '<script>window.alert("Data tidak boleh kosong!")
            window.location = "index.php"</script>';
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
                            <a class="nav-link active" href="#">Home</a>
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

    <!-- Form input gambar -->
    <div class="container mt-4">
        <h2 class="text-center">Make a New Content</h2>
        <form action="" method="post">
            <div class="row">
                <label for="candi_image" class="form-label">Judul Content</label>
                <div class="col-md-12 p-2">
                    <input type="text" class="form-control" name="title">
                </div>
                <label for="floatingTextarea">Isi Content</label>
                <div class="col-md-12 p-2">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="content"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit" name="Submit_content">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT * FROM artikel";
            $res = mysqli_query($conn,  $sql);
            while ($r = mysqli_fetch_array($res)) :
                $title = $r['title']; ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= $r['title'] ?></h5>
                            <p class="card-text"><?= substr($r['content'], 0, 150) ?>[...]</p>
                            <a href="edit_artikel.php?id=<?= $r['id'] ?>" class="btn btn-outline-dark">View More</a>
                        </div>
                        <div class="card-footer bg-transparent border-secondary">
                            <p class="card-text"><small class="text-muted">Last updated by <?= $r['author'] ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div>


    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="../assets/js/Simple-Slider.js"></script>
</body>

</html>