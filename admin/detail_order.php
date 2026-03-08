<?php
include "../config/koneksi.php";
session_start();

// proteksi admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$id = $_GET['id'];

$q = mysqli_query($conn,"
SELECT products.name, products.price, order_items.qty
FROM order_items
JOIN products ON order_items.product_id = products.id
WHERE order_items.order_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2 class="mb-4">Detail Order #<?php echo $id; ?></h2>

<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>
<tbody>

<?php
$total = 0;
while($d = mysqli_fetch_assoc($q)){
    $subtotal = $d['price'] * $d['qty'];
    $total += $subtotal;
    echo "<tr>";
    echo "<td>".$d['name']."</td>";
    echo "<td>".number_format($d['price'])."</td>";
    echo "<td>".$d['qty']."</td>";
    echo "<td>".number_format($subtotal)."</td>";
    echo "</tr>";
}
?>

<tr class="table-success">
<td colspan="3"><strong>Total</strong></td>
<td><strong><?php echo number_format($total); ?></strong></td>
</tr>

</tbody>
</table>

<a href="laporan.php" class="btn btn-secondary mt-3">Kembali ke Laporan</a>

</div>
</div>

</div>

</body>
</html>