<?php
session_start();
include "config/koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if($data){

    $_SESSION['id'] = $data['id'];
    $_SESSION['name'] = $data['name'];
    $_SESSION['role'] = $data['role'];

    if($data['role'] == 'admin'){
        header("location:admin/dashboard.php");
    }else{
        header("location:user/produk.php");
    }

}else{
    echo "Login gagal";
}
?>