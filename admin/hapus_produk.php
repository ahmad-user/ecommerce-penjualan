<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn,"DELETE FROM products WHERE id='$id'");
}

header("location:produk.php");
?>