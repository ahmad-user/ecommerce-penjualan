<?php
session_start();
include "config/koneksi.php";

// ambil semua produk
$q = mysqli_query($conn,"SELECT * FROM products");

// contoh slide images (bisa diambil dari folder assets/images/produk/)
$slides = [
    "gambar1.png",
    "gambar2.png",
    "gambar3.png"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Toko Online Modern</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">Toko Modern</a>
    <div class="ms-auto">
        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user'): ?>
        <a href="cart.php" class="btn btn-warning">
            <i class="bi bi-cart3"></i> Keranjang
        </a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <?php else: ?>
        <a href="login.php" class="btn btn-light">Login</a>
        <?php endif; ?>
    </div>
  </div>
</nav>
<!-- Slider / Carousel -->
<div class="container mt-5">
<h2 class="mb-4 text-center">Promo & Penawaran</h2>
<div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php foreach($slides as $index => $slide): ?>
    <div class="carousel-item <?php echo ($index==0)?'active':''; ?>">
      <img src="assets/images/produk/<?php echo $slide; ?>" class="d-block w-100" alt="Slide <?php echo $index+1; ?>" style="height:300px; object-fit:cover;">
    </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Sebelumnya</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Berikutnya</span>
  </button>
</div>
</div>
<div class="container mt-5">
<h2 class="mb-4 text-center">Produk Unggulan</h2>

<div class="row g-4">
<?php while($d = mysqli_fetch_assoc($q)): ?>
<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card position-relative h-100 product-card animate-on-scroll">
        <?php if($d['stock'] < 1): ?>
        <div class="ribbon">Habis</div>
        <?php endif; ?>
        <img src="assets/images/produk/<?php echo $d['images']; ?>" 
             class="card-img-top product-img" 
             alt="<?php echo $d['name']; ?>" 
             style="height:200px; object-fit:cover;">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo $d['name']; ?></h5>
            <p class="card-text mb-2">Harga: <strong>Rp <?php echo number_format($d['price'],0,",","."); ?></strong></p>
            <p class="card-text mb-2">Stok: <?php echo $d['stock']; ?></p>

            <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user'): ?>
            <form action="cart.php" method="POST" class="mt-auto d-flex gap-2">
                <input type="hidden" name="product_id" value="<?php echo $d['id']; ?>">
                <input type="number" name="qty" min="1" value="1" class="form-control form-control-sm qty-input" data-price="<?php echo $d['price']; ?>" style="width:60px;">
                <button type="submit" name="beli" class="btn btn-sm btn-primary" <?php echo ($d['stock'] < 1) ? 'disabled' : ''; ?>>
                    <?php echo ($d['stock'] < 1) ? 'Habis' : 'Beli'; ?>
                </button>
            </form>
            <?php else: ?>
            <a href="login.php?redirect=produk.php" class="btn btn-sm btn-warning mt-auto">
                <i class="bi bi-box-arrow-in-right"></i> Login untuk beli
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>