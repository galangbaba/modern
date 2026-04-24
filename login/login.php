<?php
session_start();
include 'config.php'; // Pastikan file koneksi database sudah ada

$error_message = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['username'];
            header("Location: dashboard.php"); // Ganti ke halaman utama Anda
            exit;
        } else {
            $error_message = "Kata sandi salah!";
        }
    } else {
        $error_message = "Nama pengguna tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css">
    <link rel="stylesheet" href="style.stylelogin.css">
    <title>Modern Farm - Login</title>
    <style>
        /* Tambahan sedikit agar input terlihat rapi karena sekarang menggunakan tag <input> */
        input {
            padding: 0 10px;
            box-sizing: border-box;
            outline: none;
        }
        .error-notif {
            position: absolute;
            top: 90px;
            left: 42px;
            width: 268px;
            color: #d32f2f;
            font-size: 10px;
            text-align: center;
            font-family: sans-serif;
        }
        button.group {
            border: none;
            background: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login">
            <div class="rectangle"></div>
            
            <p class="modern-farm">
                <span class="text-wrapper">Modern</span>
                <span class="span">Farm</span>
            </p>

            <?php if ($error_message !== ""): ?>
                <div class="error-notif">⚠️ <?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="text-wrapper-2">Nama Pengguna/Email</div>
                <input type="text" name="username" class="rectangle-2" placeholder="Masukkan nama pengguna" required>
                
                <div class="text-wrapper-4">Kata Sandi</div>
                <input type="password" name="password" class="rectangle-3" placeholder="Masukkan kata sandi" required>
                
                <button type="submit" name="login" class="group">
                    <div class="rectangle-4"></div>
                    <div class="text-wrapper-3">MASUK</div>
                </button>
            </form>

            <div class="text-wrapper-6" style="pointer-events: none; opacity: 0.5;">Nama Pengguna</div>
        </div>
    </div>
</body>
</html>