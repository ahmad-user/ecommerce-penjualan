<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

$query_produk = mysqli_query($conn,"SELECT COUNT(*) as total FROM products");
$data_produk = mysqli_fetch_assoc($query_produk);
$total_produk = $data_produk['total'];

// Total order
$query_order = mysqli_query($conn,"SELECT COUNT(*) as total FROM orders");
$data_order = mysqli_fetch_assoc($query_order);
$total_order = $data_order['total'];

// Total pembelian
$query_pembelian = mysqli_query($conn,"SELECT COUNT(*) as total FROM purchases");
$data_pembelian = mysqli_fetch_assoc($query_pembelian);
$total_pembelian = $data_pembelian['total'];

// Produk habis stok
$query_habis = mysqli_query($conn,"SELECT COUNT(*) as total FROM products WHERE stock=0");
$data_habis = mysqli_fetch_assoc($query_habis);
$produk_habis = $data_habis['total'];

// Data untuk chart (5 produk terakhir)
$chart_labels = [];
$chart_data = [];
$q_chart = mysqli_query($conn,"SELECT name, stock FROM products ORDER BY id DESC LIMIT 5");
while($c = mysqli_fetch_assoc($q_chart)){
    $chart_labels[] = $c['name'];
    $chart_data[] = $c['stock'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom CSS -->
<link href="../assets/css/style.css" rel="stylesheet">

</head>
<body>

<div class="container-fluid">
<div class="row">

<!-- Sidebar include -->
<?php include "sidebar.php"; ?>

<!-- Main Content -->
<div class="col-md-9 mt-4">

<h2>Dashboard Admin</h2>

<div class="row mt-4">

<!-- Kartu Statistik -->
<div class="col-md-3 mb-3">
<div class="card text-bg-primary shadow-sm">
<div class="card-body">
<h5 class="card-title"><i class="bi bi-box-seam"></i> Total Produk</h5>
<h2><?php echo $total_produk; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card text-bg-success shadow-sm">
<div class="card-body">
<h5 class="card-title"><i class="bi bi-bag-check"></i> Total Order</h5>
<h2><?php echo $total_order; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card text-bg-warning shadow-sm">
<div class="card-body">
<h5 class="card-title"><i class="bi bi-exclamation-triangle"></i> Produk Habis Stok</h5>
<h2><?php echo $produk_habis; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card text-bg-info shadow-sm">
<div class="card-body">
<h5 class="card-title"><i class="bi bi-cart-plus"></i> Total Pembelian</h5>
<h2><?php echo $total_pembelian; ?></h2>
</div>
</div>
</div>

</div> 

<!-- Tabel 5 Produk Terbaru -->
<div class="card my-4 shadow-sm">
<div class="card-header">5 Produk Terbaru</div>
<div class="card-body">
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nama</th>
<th>Stok</th>
<th>Harga</th>
</tr>
</thead>
<tbody>
<?php
$q_latest = mysqli_query($conn,"SELECT * FROM products ORDER BY id ASC LIMIT 5");
while($p = mysqli_fetch_assoc($q_latest)){
    $badge = $p['stock']==0 ? "<span class='badge bg-danger'>Habis</span>" : $p['stock'];
    echo "<tr>";
    echo "<td>".$p['id']."</td>";
    echo "<td>".$p['name']."</td>";
    echo "<td>".$badge."</td>";
    echo "<td>".number_format($p['price'])."</td>";
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

<script>
// Chart Stok 5 Produk Terakhir
const ctx = document.getElementById('chartStok').getContext('2d');
const chartStok = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chart_labels); ?>,
        datasets: [{
            label: 'Stok',
            data: <?php echo json_encode($chart_data); ?>,
            backgroundColor: ['#0d6efd','#198754','#ffc107','#0dcaf0','#6f42c1']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Stok Produk Terbaru'
            }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>