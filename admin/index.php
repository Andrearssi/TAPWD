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
    include_once("../connection.php");
    // check login
    if ($_SESSION['status'] == "login") {
    ?>
        <header>
            <nav class="navbar navbar-light navbar-expand-md navwhite">
                <div class="container">
                    <div class="navbar-brand">
                        <h3>Welcome, <?php echo $_SESSION['username'] ?></h3>
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
                                <a class="nav-link" href="#">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container pt-5 pb-4 mb-5">
            <?php
            //update sql
            if (isset($_POST['update_submit'])) {
                $username = $_POST['updt_user'];
                $id = $_POST['id'];
                $sql = "UPDATE login SET username = '$username' WHERE id = '$id'";
                $res = mysqli_query($conn, $sql);
            }
            // delete user sql
            if (isset($_POST['delete_btn'])) {
                $id = $_POST['id'];
                $sql = "DELETE FROM login WHERE id = '$id'";
                $res = mysqli_query($conn, $sql);
            }
            // update form
            if (isset($_POST['update_btn'])) {
                $id = $_POST['id'];
                $sql = "SELECT * FROM login WHERE id = '$id'";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($res);
                echo '<form method="POST" action="">
                        <input type="hidden" name="id" value="' . $id . '">
                        <div class="mb-3">
                            <label for="user" class="form-label">Username</label>
                            <input type="text" class="form-control" name="updt_user" id="user" value="' . $row['username'] . '">
                        </div>
                        <div class="mb-3">
                            <label for="passwd" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass" id="passwd" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label for="re-pass" class="form-label">Retype Password</label>
                            <input type="password" class="form-control" name="repass" id="re-pass" placeholder="Retype-password">
                        </div>
                        <button type="submit" name="update_submit" class="btn btn-success">Update</button>
                        <a class="btn btn-danger" href="index.php">Cancel</a>
                </form>';
            }
            ?>
            <div class="card shadow">
                <table class="table">
                    <thead>
                        <th scope="col">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM login";
                    $res = mysqli_query($conn, $sql);
                    $no = 1;
                    while ($row = mysqli_fetch_array($res)) {
                        echo '<tbody>
                                <tr>
                                    <th scope="row">' . $no . '</th>
                                    <td>' . $row['username'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="' . $row['id'] . '">
                                            <button type="submit" name="update_btn" class="btn btn-success">Update</button>
                                            <button type="submit" name="delete_btn" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>';
                        $no++;
                    }

                    ?>
                </table>
            </div>
        </div>

        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
        <script src="../assets/js/navbar-transparent.js"></script>
        <script src="../assets/js/Simple-Slider.js"></script>
    <?php
    } else {
        header("location:../login.php");
    }
    ?>

</body>

</html>