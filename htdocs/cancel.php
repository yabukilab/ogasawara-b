<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_ID'])) {
  header("Location: index.php");
  exit;
}

$user_id = $_SESSION['user_ID'];

// ユーザーのメールアドレスを取得
$sql = "SELECT email FROM users WHERE ID = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("ユーザー情報の取得に失敗しました。");
}

$email = $user['email'];
$error = '';
$success = '';
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $reason = $_POST['reason'] ?? '';

  if (empty(trim($reason))) {
    $error = "中止理由を入力してください。";
  } else {
    try {
      $sql = "INSERT INTO reporting (mailaddress, reason) VALUES (:mail, :reason)";
      $stmt = $db->prepare($sql);
      $stmt->execute([
        ':mail' => $email,
        ':reason' => $reason
      ]);
      $success = "報告を送信しました。5秒後にホームに戻ります。";
      $redirect = true;
    } catch (PDOException $e) {
      $error = "送信エラー: " . htmlspecialchars($e->getMessage());
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>取引中止画面</title>
  <link rel="stylesheet" href="common_style.css">
  <style>
    .container {
      background: #fff;
      padding: 40px;
      width: 360px;
      margin: auto;
      border: 1px solid #ccc;
    }

    textarea {
      width: 100%;
      height: 150px;
      padding: 10px;
      resize: none;
    }

    .button-pair {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 10px;
    }

    .send-button, .return-button {
      background-color: #336699;
      color: white;
      padding: 12px 0;
      font-size: 16px;
      border: none;
      width: 40%;
      cursor: pointer;
      text-align: center;
    }

    .message {
      font-size: 14px;
      color: red;
      margin-bottom: 10px;
      text-align: center;
    }

    .success {
      color: green;
    }
  </style>
  <?php if ($redirect): ?>
    <meta http-equiv="refresh" content="5;url=home.php">
  <?php endif; ?>
</head>
<body>

  <div class="container">
    <form method="post" action="">
      <p>この取引を中止します。<br>中止する理由を入力してください。</p>

      <textarea name="reason" placeholder="コメントを入力してください" required></textarea>

      <?php if (!empty($error)): ?>
        <div class="message"><?= $error ?></div>
      <?php elseif (!empty($success)): ?>
        <div class="message success"><?= $success ?></div>
      <?php endif; ?>

      <div class="button-pair">
        <button type="submit" class="send-button">送信</button>
        <a href="home.php" class="return-button">戻る</a>
      </div>
    </form>
  </div>

</body>
</html>