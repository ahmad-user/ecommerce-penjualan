<?php
include "config/koneksi.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

mysqli_query($conn,"INSERT INTO users (name,email,password,role)
VALUES ('$name','$email','$password','user')");

header("location:login.php");
?>