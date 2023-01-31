<?php
session_start();
session_destroy();
echo '<script>window.alert("Anda Berhasil Logout")
    window.location = "http://localhost:8080//PWD/TA/login.php"</script>';
