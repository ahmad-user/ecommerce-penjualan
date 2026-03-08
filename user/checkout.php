<?php
session_start();
include "../config/koneksi.php";

// proteksi 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
    header("location:../login.php");
    exit;
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    unset($_SESSION['cart'][$id]);
    header("location:checkout.php");
    exit;
}

if(isset($_POST['update_cart'])){
    foreach($_POST['qty'] as $id => $qty){
        $qty = intval($qty);
        if($qty <= 0){
            unset($_SESSION['cart'][$id]);
        } else {
            // cek stok
            $q_stock = mysqli_query($conn,"SELECT stock FROM products WHERE id='$id'");
            $d_stock = mysqli_fetch_assoc($q_stock);
            if($qty > $d_stock['stock']){
                $qty = $d_stock['stock'];
            }
            $_SESSION['cart'][$id] = $qty;
        }
    }
    header("location:checkout.php");
    exit;
}

// ===== Checkout =====
$success = "";
if(isset($_POST['checkout'])){
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        $success = "Keranjang kosong!";
    } else {
        $user_id = $_SESSION['id'];
        mysqli_query($conn,"INSERT INTO orders(user_id,date) VALUES('$user_id',NOW())");
        $order_id = mysqli_insert_id($conn);

        foreach($_SESSION['cart'] as $id=>$qty){
            mysqli_query($conn,"INSERT INTO order_items(order_id,product_id,qty) VALUES('$order_id','$id','$qty')");
            mysqli_query($conn,"UPDATE products SET stock = stock - $qty WHERE id = $id");
        }

        unset($_SESSION['cart']);
        $success = "Order berhasil disimpan!";
    }
}

// ===== Ambil data produk dari cart =====
$products = [];
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    $cart_ids = implode(",", array_keys($_SESSION['cart']));
    $q = mysqli_query($conn,"SELECT * FROM products WHERE id IN ($cart_ids)");
    while($d = mysqli_fetch_assoc($q)){
        $products[$d['id']] = $d;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h2 class="mb-4 text-center">Checkout</h2>

<?php if($success): ?>
<div class="alert alert-success"><?php echo $success; ?> 
    <?php if($success=="Order berhasil disimpan!") echo '<a href="produk.php">Belanja lagi</a>'; ?>
</div>
<?php endif; ?>

<?php if(!empty($products)): ?>
<form method="POST">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Gambar</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php 
$total = 0;
$no = 1;
foreach($_SESSION['cart'] as $id=>$qty):
    $product = $products[$id];
    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
?>
<tr>
    <td><?php echo $no++; ?></td>
    <td>
        <img src="../assets/images/produk/<?php echo $product['images']; ?>" 
             alt="<?php echo $product['name']; ?>" 
             style="width:80px; height:80px; object-fit:cover;">
    </td>
    <td><?php echo $product['name']; ?></td>
    <td>Rp <?php echo number_format($product['price'],0,",","."); ?></td>
    <td>
        <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="0" 
               class="form-control form-control-sm" style="width:70px"
               data-price="<?php echo $product['price']; ?>">
    </td>
    <td id="subtotal-<?php echo $id; ?>">Rp <?php echo number_format($subtotal,0,",","."); ?></td>
    <td>
        <a href="checkout.php?hapus=<?php echo $id; ?>" class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i> Hapus
        </a>
    </td>
</tr>
<?php endforeach; ?>
<tr>
    <td colspan="5" class="text-end"><strong>Total</strong></td>
    <td colspan="2"><strong id="total-order">Rp <?php echo number_format($total,0,",","."); ?></strong></td>
</tr>
</tbody>
</table>

<div class="d-flex justify-content-between mt-3">
    <button type="submit" name="checkout" class="btn btn-success">
        <i class="bi bi-cart-check"></i> Checkout Sekarang
    </button>
    <button type="submit" name="update_cart" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise"></i> Update Cart
    </button>
</div>
</form>

<div class="mt-3">
    <a href="produk.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali ke Produk</a>
</div>

<?php else: ?>
<div class="alert alert-info">Keranjang masih kosong. <a href="produk.php">Belanja sekarang</a></div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>