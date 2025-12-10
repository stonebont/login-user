<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
<p>Anda berhasil login.</p>
<a href="logout.php">Logout</a>