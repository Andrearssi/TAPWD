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

        $sql_candi = "SELECT id FROM candi WHERE nama = '$nama_candi' LIMIT 1";
        $result = mysqli_query($conn, $sql_candi);
        $r = mysqli_fetch_array($result);
        $id_candi = $r['id'];

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
                    $sql = "INSERT INTO image VALUES('','$id_candi','$new_img_name')";
                    mysqli_query($conn, $sql);
                    header("Location: gallery-admin.php");
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
