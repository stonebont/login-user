<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-3">Daftar</h3>
    <form id="formRegister">
        <input type="hidden" name="action" value="register">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Daftar</button>
    </form>
    <div class="mt-3 text-center">
        <a href="index.php">Sudah punya akun? Login</a>
    </div>
</div>

<script>
document.getElementById('formRegister').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('auth.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if(data.status === 'success') window.location.href = 'index.php';
    });
});
</script>
</body>
</html>