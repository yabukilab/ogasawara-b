<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>ログイン</h2>

        <form method="POST" action="check_login.php">
            <label>メールアドレス</label>
            <input type="email" name="email" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <button type="submit" class="login-btn">ログイン</button>
        </form>

        <a href="register.php" class="register-link">新規登録</a>
    </div>
</body>
</html>
