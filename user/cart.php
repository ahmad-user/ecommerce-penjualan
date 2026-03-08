<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
    header("location:../login.php");
    exit;
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// tambah produk ke cart
if(isset($_POST['beli'])){
    $product_id = $_POST['product_id'];
    $qty = intval($_POST['qty']);

    // cek stok
    $q = mysqli_query($conn,"SELECT stock FROM products WHERE id='$product_id'");
    $d = mysqli_fetch_assoc($q);
    if($qty > $d['stock']){
        $qty = $d['stock']; // batasi sesuai stok
    }

    // jika produk sudah ada di cart, update qty
    if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }

    header("location:cart.php"); 
    exit;
}

// hapus produk dari cart
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    unset($_SESSION['cart'][$id]);
    header("location:cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Keranjang Belanja</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2 class="mb-4">Keranjang Belanja</h2>

<?php if(empty($_SESSION['cart'])): ?>
<div class="alert alert-info">Keranjang masih kosong</div>
<?php else: ?>
<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>Produk</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$total = 0;
foreach($_SESSION['cart'] as $product_id => $qty){
    $q = mysqli_query($conn,"SELECT * FROM products WHERE id='$product_id'");
    $p = mysqli_fetch_assoc($q);
    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
    echo "<tr>";
    echo "<td>".$p['name']."</td>";
    echo "<td>".$qty."</td>";
    echo "<td>".number_format($p['price'])."</td>";
    echo "<td>".number_format($subtotal)."</td>";
    echo "<td><a href='cart.php?hapus=$product_id' class='btn btn-sm btn-danger'>Hapus</a></td>";
    echo "</tr>";
}
?>
<tr>
<td colspan="3" class="text-end"><strong>Total</strong></td>
<td colspan="2"><strong><?php echo number_format($total); ?></strong></td>
</tr>
</tbody>
</table>
<a href="checkout.php" class="btn btn-success">Checkout</a>
<?php endif; ?>

<a href="produk.php" class="btn btn-primary mt-3">Lanjut Belanja</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>