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
<title>Riwayat Pembelian</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>

<div class="col-md-9 mt-4">
<h2 class="mb-4">Riwayat Pembelian</h2>

<div class="mb-3">
    <a href="tambah_pembelian.php" class="btn btn-success">Tambah Pembelian</a>
</div>

<div class="card">
<div class="card-header">Daftar Pembelian</div>
<div class="card-body">
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Produk</th>
<th>Qty</th>
<th>Tanggal</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$q = mysqli_query($conn,"
SELECT purchases.*, products.name
FROM purchases
JOIN products ON purchases.product_id = products.id
ORDER BY purchases.id DESC
");
while($d = mysqli_fetch_assoc($q)){
    echo "<tr>";
    echo "<td>".$d['id']."</td>";
    echo "<td>".$d['name']."</td>";
    echo "<td>".$d['qty']."</td>";
    echo "<td>".$d['date']."</td>";
    echo "<td>
            <a href='edit_pembelian.php?id=".$d['id']."' class='btn btn-sm btn-warning'>Edit</a>
            <a href='hapus_pembelian.php?id=".$d['id']."' class='btn btn-sm btn-danger' 
               onclick=\"return confirm('Yakin ingin hapus pembelian ini?')\">Hapus</a>
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
</body>
</html>