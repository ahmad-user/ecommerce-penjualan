<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$success_msg = "";
?>
<!DOCTYPE html>
<html>
<head>
<title>Kelola Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>
<div class="col-md-9 mt-4">
<h2 class="mb-4">Kelola Produk</h2>
<div class="mb-3">
    <a href="tambah_produk.php" class="btn btn-success">Tambah Produk</a>
</div>

<?php if($success_msg != ""): ?>
<div class="alert alert-success"><?php echo $success_msg; ?></div>
<?php endif; ?>
<div class="card">
<div class="card-header">Daftar Produk</div>
<div class="card-body">
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nama</th>
<th>Image</th>
<th>Harga</th>
<th>Stok</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$q = mysqli_query($conn,"SELECT * FROM products");
while($d = mysqli_fetch_assoc($q)){
    echo "<tr>";
    echo "<td>".$d['id']."</td>";
    echo "<td>".$d['name']."</td>";
    echo "<td><img src='../assets/images/produk/".$d['images']."' width='50'></td>";
    echo "<td>".number_format($d['price'])."</td>";
    echo "<td>".$d['stock']."</td>";
    echo "<td>
            <a href='edit_produk.php?id=".$d['id']."' class='btn btn-sm btn-warning'>Edit</a>
            <a href='hapus_produk.php?id=".$d['id']."' class='btn btn-sm btn-danger' 
               onclick=\"return confirm('Yakin ingin hapus produk ini?')\">Hapus</a>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div> 
</div> 
</div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>