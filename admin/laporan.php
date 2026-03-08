<?php
include "../config/koneksi.php";
session_start();

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$q = mysqli_query($conn,"
SELECT orders.id, users.name, orders.date
FROM orders
JOIN users ON orders.user_id = users.id
ORDER BY orders.date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>
<div class="col-md-9 mt-4">
<div class="container mt-5">

<h2 class="mb-4">Laporan Penjualan</h2>

<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID Order</th>
<th>Customer</th>
<th>Tanggal</th>
<th>Detail</th>
</tr>
</thead>
<tbody>

<?php
while($d = mysqli_fetch_assoc($q)){
    echo "<tr>";
    echo "<td>".$d['id']."</td>";
    echo "<td>".$d['name']."</td>";
    echo "<td>".$d['date']."</td>";
    echo "<td><a href='detail_order.php?id=".$d['id']."' class='btn btn-sm btn-primary'>Lihat</a></td>";
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
</div>
<!-- Optional JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="../assets/js/script.js"></script>
</body>
</html>