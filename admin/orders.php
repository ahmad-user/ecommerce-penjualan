<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

if(isset($_GET['acc'])){
    $id = $_GET['acc'];
    mysqli_query($conn,"UPDATE orders SET status='completed' WHERE id='$id'");
    header("location:orders.php");
    exit;
}

$q = mysqli_query($conn,"
    SELECT orders.*, users.name as username
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.id ASC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Kelola Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>

<div class="col-md-9 mt-4">
<h2>Kelola Order</h2>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>User</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php while($d = mysqli_fetch_assoc($q)): ?>
<tr>
<td><?php echo $d['id']; ?></td>
<td><?php echo $d['username']; ?></td>
<td><?php echo $d['date']; ?></td>
<td><?php echo ucfirst($d['status']); ?></td>
<td>
<?php if($d['status']=='pending'): ?>
<a href="orders.php?acc=<?php echo $d['id']; ?>" class="btn btn-sm btn-success">ACC</a>
<?php else: ?>
<span class="text-success">Sudah ACC</span>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>