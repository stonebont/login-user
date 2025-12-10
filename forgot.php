<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 400px;">
    <h3 class="text-center mb-3">Reset Password</h3>
    <form id="formForgot">
        <input type="hidden" name="action" value="forgot">
        <div class="mb-3">
            <label>Masukkan Email Anda</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Kirim Link Reset</button>
    </form>
    <div id="result" class="mt-3 text-break text-success"></div>
    <div class="mt-3 text-center"><a href="index.php">Kembali Login</a></div>
</div>

<script>
document.getElementById('formForgot').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('auth.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            // Karena tidak ada email server, kita tampilkan link di layar
            document.getElementById('result').innerHTML = 
                "<b>Silakan klik link ini (Simulasi Email):</b><br><a href='"+ data.message.split(': ')[1] +"'>Klik Disini untuk Reset</a>";
        } else {
            alert(data.message);
        }
    });
});
</script>
</body>
</html>