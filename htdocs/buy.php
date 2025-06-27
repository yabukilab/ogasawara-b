<?php
session_start();
require 'db_connect.php';

// ログインチェック
if (!isset($_SESSION['user_ID'])) {
  header("Location: login.php");
  exit;
}

$dbServer = '127.0.0.1';
$dbUser   = $_SERVER['MYSQL_USER']     ?? 'testuser';
$dbPass   = $_SERVER['MYSQL_PASSWORD'] ?? 'pass';
$dbName   = $_SERVER['MYSQL_DB']       ?? 'mydb';

$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
    $db = new PDO($dsn, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "DB接続失敗: " . h($e->getMessage());
    exit();
}

$user_id = $_SESSION['user_ID']; // ← 購入者ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 商品ID取得
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id > 0) {
  // 購入処理：bflagを1にし、buyer_IDを登録
  $sql = "UPDATE products SET bflag = 1, buyer_ID = :buyer WHERE ID = :id AND bflag = 0";
  $stmt = $db->prepare($sql);
  $stmt->execute([
    ':buyer' => $user_id,
    ':id' => $product_id
  ]);

  // チャット画面に遷移（例: chat.php?id=○）
  header("Location: chat.php?id=" . $product_id);
  exit;
} else {
  echo "商品IDが不正です。";
}
?>
