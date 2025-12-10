<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-3">Login</h3>
    <form id="formLogin">
        <input type="hidden" name="action" value="login">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
    <div class="mt-3 text-center">
        <a href="register.php">Daftar Akun</a> | <a href="forgot.php">Lupa Password?</a>
    </div>
</div>

<script>
document.getElementById('formLogin').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('auth.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            window.location.href = 'dashboard.php';
        } else {
            alert(data.message);
        }
    });
});
</script>

</body>
</html>