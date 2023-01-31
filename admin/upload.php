<?php
session_start();
if (!$_SESSION['status']) {
    header("Location: ../login.php");
} else {
    if (isset($_POST['submit']) && isset($_FILES['gambar'])) {
        include_once("../connection.php");

        $img_name = $_FILES['gambar']['name'];
        $img_size = $_FILES['gambar']['size'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $nama_candi = $_POST['nama_candi'];
        $error = $_FILES['gambar']['error'];
        $user = $_SESSION['username'];
        date_default_timezone_set("ASIA/JAKARTA");
        $tanggal = date("Y-m-d H:i:s");

        $sql_candi = "SELECT * FROM artikel WHERE title = '$nama_candi' LIMIT 1";
        $result = mysqli_query($conn, $sql_candi);
        $r = mysqli_fetch_array($result);
        $id_artikel = $r['id'];
        $title = $r['title'];
        $content = $r['content'];

        if ($error === 0) {
            if ($img_size > 5000000) {
                $em = urlencode("Sorry, your file is too large.");
                header("Location: gallery-admin.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");
                $jpg = array("jpg", "jpeg");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

                    $img_upload_path = '../uploads/' . $new_img_name;

                    move_uploaded_file($tmp_name, $img_upload_path);

                    list($width, $height) = getimagesize($img_upload_path);
                    $newWidth = 2000;
                    $newHeight = 1335;
                    $thumb = imagecreatetruecolor($newWidth, $newHeight);
                    if (in_array($img_ex_lc, $jpg)) {
                        $source = imagecreatefromjpeg($img_upload_path);
                    } else {
                        $source = imagecreatefrompng($img_upload_path);
                    }

                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    // Save the resized image to a new file
                    if (in_array($img_ex_lc, $jpg)) {
                        imagejpeg($thumb, $img_upload_path);
                    } else {
                        imagepng($thumb, $img_upload_path);
                    }

                    // Clean up
                    imagedestroy($thumb);
                    imagedestroy($source);

                    // Insert into Database
                    $sql = "INSERT INTO image(id_artikel,author,image) VALUES('$id_artikel','$user','$new_img_name')";
                    mysqli_query($conn, $sql);

                    $sql2 = "INSERT INTO logs(user,tabel,action,time_edit) VALUES ('$user','image', 'UPLOAD', '$tanggal')";
                    mysqli_query($conn, $sql2);
                    $sql3 = "UPDATE artikel SET author = '$user',title = '$title', content = '$content' WHERE id = $id_artikel";
                    mysqli_query($conn, $sql3);
                    echo "<script>window.alert('Upload Success')
                                window.location = 'http://localhost:8080//PWD/TA/admin/gallery-admin.php'</script>";
                } else {
                    $em = urlencode("You can't upload files of this type");
                    header("Location: gallery-admin.php?error=$em");
                }
            }
        } else {
            $em = urlencode("unknown error occurred!");
            header("Location: gallery-admin.php?error=$em");
        }
    } else {
        header("Location: gallery-admin.php");
    }
}
