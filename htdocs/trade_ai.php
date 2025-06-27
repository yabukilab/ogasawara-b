<?php
// エラー表示
error_reporting(E_ALL);
ini_set('display_errors', '1');

// DB接続設定
$host = 'localhost';
$db   = 'mydb';
$user   = 'testuser';
$pass = 'pass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("DB接続失敗: " . $e->getMessage());
}

// --- POST送信処理 ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'] ?? '匿名';
  $message = $_POST['message'] ?? '';

  if (!empty(trim($message))) {
    $stmt = $pdo->prepare("INSERT INTO chat_messages (username, message, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$username, $message]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }
}

// --- メッセージ取得処理 ---
$messages = [];
$stmt = $pdo->query("SELECT username, message, created_at FROM chat_messages ORDER BY created_at ASC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>取引画面</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container {
      max-width: 500px;
      margin: auto;
      padding: 20px;
      background: white;
      border: 1px solid #ccc;
    }
    .chat-box {
      height: 300px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #f9f9f9;
    }
    .message-input {
      width: 90%;
      padding: 10px;
      margin-bottom: 10px;
    }
    .button-pair {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }
    .button-pair .cancel-button {
      width: 48%;
    }
    .button-pair .end-button {
      width: 48%;
    }
    .home-button {
      margin-bottom: 10px;
      background: white;
      border: 1px solid #336699;
      color: #336699;
      padding: 8px 12px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container">
  <button class="home-button" onclick="location.href='home.php'">ホーム画面に戻る</button>

  <div class="chat-box" id="chat-box">
    <?php foreach ($messages as $row): ?>
      <p>
        <strong><?= htmlspecialchars($row['username']) ?></strong>
        <?= htmlspecialchars($row['created_at']) ?><br>
        <?= nl2br(htmlspecialchars($row['message'])) ?>
      </p>
      <hr>
    <?php endforeach; ?>
  </div>

  <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="hidden" name="username" value="あなた">
    <input type="text" name="message" class="message-input" placeholder="メッセージを入力">
    <button type="submit" class="send-button">送信</button>
  </form>

  <div class="button-pair">
    <a href="cancel.php" class="cancel-button">取引中止</a>
    <a href="home.php" class="end-button">取引完了</a>
  </div>
</div>

</body>
</html>