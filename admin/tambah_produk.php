<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$success_msg = "";

if(isset($_POST['simpan'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $gambar = $_FILES['images']['name'];
    $tmp = $_FILES['images']['tmp_name'];
    $folder = "../assets/images/produk/";
    move_uploaded_file($tmp, $folder.$gambar);

    mysqli_query($conn,"INSERT INTO products(name,price,stock,images)
                        VALUES('$name','$price','$stock','$gambar')");

    $success_msg = "Produk berhasil ditambah!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <h2 class="mb-4 text-center">Tambah Produk</h2>

            <?php if($success_msg != ""): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Form Produk</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" name="images" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="produk.php" class="btn btn-secondary">Kembali</a>
                            <button name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>