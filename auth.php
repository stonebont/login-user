<?php
require 'db.php';

header('Content-Type: application/json');
$action = $_POST['action'] ?? '';

// --- REGISTER ---
if ($action == 'register') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    try {
        $stmt = $pdo->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $email, $pass]);
        echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil! Silakan login.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar atau error lain.']);
    }
}

// --- LOGIN ---
elseif ($action == 'login') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email atau Password salah!']);
    }
}

// --- FORGOT PASSWORD (REQUEST TOKEN) ---
elseif ($action == 'forgot') {
    $email = $_POST['email'];
    
    // Cek email ada atau tidak
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $token = bin2hex(random_bytes(50)); // Generate token random
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s", $expFormat);

        // Simpan token ke DB
        // Hapus token lama jika ada
        $pdo->prepare("DELETE FROM password_resets WHERE email=?")->execute([$email]);
        
        $sql = "INSERT INTO password_resets (email, token, exp_date) VALUES (?, ?, ?)";
        $pdo->prepare($sql)->execute([$email, $token, $expDate]);

        // CATATAN: Di aplikasi nyata, gunakan PHPMailer untuk kirim link ini ke email.
        // Di sini kita kirim link balik ke browser untuk simulasi/testing.
        $link = "http://localhost/login-user/reset.php?key=" . $email . "&token=" . $token;
        
        echo json_encode(['status' => 'success', 'message' => 'Link reset (Simulasi): ' . $link]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email tidak ditemukan.']);
    }
}

// --- RESET PASSWORD (UPDATE DB) ---
elseif ($action == 'reset_pass') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $curDate = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE key=? AND token=?");
    // Periksa token valid dan belum expired
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE email=? AND token=?");
    $stmt->execute([$email, $token]);
    $row = $stmt->fetch();

    if ($row && $row['exp_date'] >= $curDate) {
        // Update Password User
        $pdo->prepare("UPDATE users SET password=? WHERE email=?")->execute([$pass, $email]);
        // Hapus token
        $pdo->prepare("DELETE FROM password_resets WHERE email=?")->execute([$email]);
        
        echo json_encode(['status' => 'success', 'message' => 'Password berhasil diubah! Silakan login.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Link expired atau tidak valid.']);
    }
}
?>