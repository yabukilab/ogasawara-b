<?php
require 'db_connect.php'; // ← ここで接続

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($password !== $confirm_password) {
  header("Location: register.php");
  exit;
}

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 同じメールがすでに存在しないかチェック
$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) {
  echo "このメールアドレスはすでに登録されています";
  exit;
}

// 登録処理
$stmt = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hashed_password]);

// 登録完了画面へ
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了</title>
  <meta http-equiv="refresh" content="5;url=login.php">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <p>新規登録しました</p>
    <p><strong>5秒後にログイン画面に戻ります</strong></p>
    <a href="login.php" class="return-btn">ログイン画面に戻る</a>
  </div>
</body>
</html>
