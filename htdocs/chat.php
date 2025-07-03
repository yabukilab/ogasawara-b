<?php
session_start();

// DB接続（db_connect.php 読み込み or 直書きどちらでもOK）
require 'db_connect.php';

// ログイン確認
if (!isset($_SESSION['user_ID'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_ID'];

// エラー表示
error_reporting(E_ALL);
ini_set('display_errors', '1');

// --- trIDの取得（URLの ?id=123 を使う）---
$trID = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($trID <= 0) {
  die('商品IDが不正です。');
}

// --- メッセージ送信処理 ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $message = trim($_POST['message'] ?? '');

  if ($message !== '') {
    $sql = "INSERT INTO chat (trID, `s-userID`, message, datetime) VALUES (?, ?, ?, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->execute([$trID, $user_id, $message]);
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $trID);
    exit;
  }
}

// --- メッセージ取得 ---
$sql = "SELECT `s-userID`, message, datetime FROM chat WHERE trID = ? ORDER BY datetime ASC";
$stmt = $db->prepare($sql);
$stmt->execute([$trID]);
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

  <div class="chat-box">
    <?php foreach ($messages as $row): ?>
      <p>
        <strong>ユーザID: <?= htmlspecialchars($row['s-userID']) ?></strong>
        <?= htmlspecialchars($row['datetime']) ?><br>
        <?= nl2br(htmlspecialchars($row['message'])) ?>
      </p>
      <hr>
    <?php endforeach; ?>
  </div>

  <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($trID) ?>" method="post">
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