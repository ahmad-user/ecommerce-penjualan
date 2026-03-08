<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("location:pembelian.php");
    exit;
}

$id = $_GET['id'];
$q = mysqli_query($conn,"SELECT * FROM purchases WHERE id='$id'");
$data = mysqli_fetch_assoc($q);
$success_msg = "";

// proses update pembelian
if(isset($_POST['update'])){
    $old_qty = $data['qty'];
    $product_id = $_POST['product_id'];
    $new_qty = $_POST['qty'];
    mysqli_query($conn,"UPDATE products SET stock = stock - $old_qty + $new_qty WHERE id = $product_id");
    mysqli_query($conn,"UPDATE purchases SET product_id='$product_id', qty='$new_qty' WHERE id='$id'");

    $success_msg = "Pembelian berhasil diupdate!";
    $q = mysqli_query($conn,"SELECT * FROM purchases WHERE id='$id'");
    $data = mysqli_fetch_assoc($q);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Pembelian</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">

<h2 class="mb-4 text-center">Edit Pembelian</h2>

<?php if($success_msg != ""): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $success_msg; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
<div class="card-header bg-warning text-white">Form Edit Pembelian</div>
<div class="card-body">
<form method="POST">
<div class="mb-3">
<label class="form-label">Produk</label>
<select name="product_id" class="form-control" required>
<?php
$q_prod = mysqli_query($conn,"SELECT * FROM products");
while($d_prod = mysqli_fetch_assoc($q_prod)){
    $sel = $d_prod['id'] == $data['product_id'] ? "selected" : "";
    echo "<option value='".$d_prod['id']."' $sel>".$d_prod['name']."</option>";
}
?>
</select>
</div>
<div class="mb-3">
<label class="form-label">Qty</label>
<input type="number" name="qty" class="form-control" required value="<?php echo $data['qty']; ?>">
</div>
<div class="d-flex justify-content-between">
<a href="pembelian.php" class="btn btn-secondary">Kembali</a>
<button name="update" class="btn btn-primary">Update</button>
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