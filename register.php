<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register Toko Online</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7fb;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card-register{
    width:400px;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    background:white;
}
</style>

</head>
<body>

<div class="card-register">

<h3 class="text-center mb-4">Register</h3>

<form method="POST" action="proses_register.php">

<div class="mb-3">
<label class="form-label">Nama</label>
<input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
</div>

<button type="submit" class="btn btn-primary w-100">Register</button>

<p class="text-center mt-3">
Sudah punya akun? <a href="login.php">Login</a>
</p>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>