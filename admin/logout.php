<?php
session_start();
session_destroy();
header("location:../index.php"); //goto index.php
