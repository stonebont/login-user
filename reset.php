<?php 
if(!isset($_GET['key']) || !isset($_GET['token'])) { die("Link tidak valid"); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Password Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-3">Password Baru</h3>
    <form id="formReset">
        <input type="hidden" name="action" value="reset_pass">
        <input type="hidden" name="email" value="<?php echo $_GET['key']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ubah Password</button>
    </form>
</div>

<script>
document.getElementById('formReset').addEventListener('submit', function(e) {
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