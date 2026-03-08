<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$success_msg = "";

// proses tambah pembelian
if(isset($_POST['beli'])){
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    mysqli_query($conn,"INSERT INTO purchases(product_id,qty,date) VALUES('$product_id','$qty',NOW())");
    mysqli_query($conn,"UPDATE products SET stock = stock + $qty WHERE id = $product_id");

    $success_msg = "Pembelian berhasil ditambah!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Pembelian</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">

<h2 class="mb-4 text-center">Tambah Pembelian</h2>

<?php if($success_msg != ""): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $success_msg; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
<div class="card-header bg-primary text-white">Form Pembelian</div>
<div class="card-body">
<form method="POST">
<div class="mb-3">
<label class="form-label">Produk</label>
<select name="product_id" class="form-control" required>
<?php
$q = mysqli_query($conn,"SELECT * FROM products");
while($d = mysqli_fetch_assoc($q)){
    echo "<option value='".$d['id']."'>".$d['name']."</option>";
}
?>
</select>
</div>
<div class="mb-3">
<label class="form-label">Qty</label>
<input type="number" name="qty" class="form-control" required>
</div>
<div class="d-flex justify-content-between">
<a href="pembelian.php" class="btn btn-secondary">Kembali</a>
<button name="beli" class="btn btn-primary">Simpan</button>
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