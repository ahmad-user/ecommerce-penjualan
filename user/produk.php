<?php
session_start();
include "../config/koneksi.php";

// proteksi login user
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
    header("location:../login.php");
    exit;
}

// Ambil semua produk
$q = mysqli_query($conn,"SELECT * FROM products");

// Hitung jumlah item di cart
$jumlah_cart = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Produk</h2>
    <div>
        <a href="cart.php" class="btn btn-warning me-2">
            <i class="bi bi-cart3"></i> Keranjang 
            <?php if($jumlah_cart > 0) echo "($jumlah_cart)"; ?>
        </a>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="row">
<?php while($d = mysqli_fetch_assoc($q)): ?>
<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 shadow-sm">
        <!-- Gambar produk -->
        <img src="../assets/images/produk/<?php echo $d['images']; ?>" 
             class="card-img-top" 
             alt="<?php echo $d['name']; ?>" 
             style="height:200px; object-fit:cover;">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo $d['name']; ?></h5>
            <p class="card-text mb-1">Harga: Rp <?php echo number_format($d['price'],0,",","."); ?></p>
            <p class="card-text mb-2">Stok: <?php echo $d['stock']; ?></p>

            <form action="cart.php" method="POST" class="mt-auto d-flex gap-2">
                <input type="hidden" name="product_id" value="<?php echo $d['id']; ?>">
                <input type="number" name="qty" min="1" value="1" class="form-control form-control-sm" style="width:60px;">
                <button type="submit" name="beli" class="btn btn-sm btn-primary" <?php echo ($d['stock'] < 1) ? 'disabled' : ''; ?>>
                    <?php echo ($d['stock'] < 1) ? 'Habis' : 'Tambah ke Keranjang'; ?>
                </button>
            </form>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>