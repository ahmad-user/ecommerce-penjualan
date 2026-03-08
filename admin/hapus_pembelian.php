<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $q = mysqli_query($conn,"SELECT * FROM purchases WHERE id='$id'");
    $data = mysqli_fetch_assoc($q);
    mysqli_query($conn,"UPDATE products SET stock = stock - ".$data['qty']." WHERE id=".$data['product_id']);

    mysqli_query($conn,"DELETE FROM purchases WHERE id='$id'");
}

header("location:pembelian.php");
exit;