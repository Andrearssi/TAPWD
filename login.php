<?php
if (isset($_POST['Submit'])) {
  include_once('connection.php');

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM user WHERE email='$email' AND password='$password' LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $cek = mysqli_num_rows($result);
  $r = mysqli_fetch_array($result);

  if ($cek > 0) {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $r['username'];
    $_SESSION['status'] = "login";
    mysqli_close($conn);
    header("location: admin/index.php");
  } else {
    mysqli_close($conn);
    echo '<script>
            window.alert("Username / Password Salah")
            window.location = "http://localhost:8080//PWD/TA/login.php"
        </script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>pwd</title>
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
              <a class="nav-link" href="blog.php">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="position-relative py-4 py-xl-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <h2><strong>L O G I N</strong></h2>
        </div>
      </div>

      <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-xl-6">
          <div class="card mb-5">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                </svg>
              </div>

              <form class="text-center" method="post" action="login.php" onsubmit="return validasi()">
                <div class="mb-3">
                  <input id="email" class="form-control" type="email" name="email" placeholder="Email" />
                </div>
                <div class="mb-3">
                  <input id="password" class="form-control" type="password" name="password" placeholder="Password" />
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-block w-100" type="submit" name="Submit">
                    Login
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
  <script src="assets/js/Simple-Slider.js"></script>
  <script src="assets/js/validationlogin.js"></script>
</body>

</html>