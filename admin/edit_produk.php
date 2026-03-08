<?php
session_start();
include "../config/koneksi.php";

// Proteksi login admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location:../login.php");
    exit;
}

// Ambil ID produk dari URL
if(!isset($_GET['id'])){
    header("location:produk.php");
    exit;
}

$id = $_GET['id'];

// Ambil data produk
$q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
if(mysqli_num_rows($q) == 0){
    echo "Produk tidak ditemukan!";
    exit;
}
$data = mysqli_fetch_assoc($q);
$success_msg = "";

// Proses update
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Cek apakah ada gambar baru
    if($_FILES['images']['name']){
        $gambar = $_FILES['images']['name'];
        $tmp = $_FILES['images']['tmp_name'];
        $folder = "../assets/images/produk/";

        // Hapus gambar lama
        if(file_exists($folder.$data['images'])){
            unlink($folder.$data['images']);
        }

        move_uploaded_file($tmp, $folder.$gambar);
        mysqli_query($conn, "UPDATE products SET name='$name', price='$price', stock='$stock', images='$gambar' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE products SET name='$name', price='$price', stock='$stock' WHERE id='$id'");
    }

    $success_msg = "Produk berhasil diupdate!";
    // Refresh data setelah update
    $q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
    $data = mysqli_fetch_assoc($q);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

<h2>Edit Produk</h2>

<?php if($success_msg != ""): ?>
<div class="alert alert-success"><?php echo $success_msg; ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" enctype="multipart/form-data">
<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($data['name']); ?>">
</div>
<div class="mb-3">
    <label class="form-label">Gambar Produk</label>
    <input type="file" name="images" class="form-control" accept="image/*">
    <?php if($data['images'] != ''): ?>
        <img src="../assets/images/produk/<?php echo $data['images']; ?>" width="100" class="mt-2">
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="price" class="form-control" required value="<?php echo $data['price']; ?>">
</div>
<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stock" class="form-control" required value="<?php echo $data['stock']; ?>">
</div>
<button name="update" class="btn btn-primary">Update</button>
<a href="produk.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>