<?php
function h($var) {
  return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
}

# DB接続
$dbServer = '127.0.0.1';
$dbUser = $_SERVER['MYSQL_USER'] ?? 'testuser';
$dbPass = $_SERVER['MYSQL_PASSWORD'] ?? 'pass';
$dbName = $_SERVER['MYSQL_DB'] ?? 'mydb';

$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "DB接続失敗: " . h($e->getMessage());
  exit();
}

# 商品ID取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

# 商品情報取得
$sql = "SELECT * FROM products WHERE ID = :id AND bflag = 0";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
  echo "商品が見つかりません。";
  exit();
}

function imageTag($blob) {
  if (!empty($blob)) {
    $base64 = base64_encode($blob);
    return '<img src="data:image/jpeg;base64,' . $base64 . '" alt="商品画像">';
  } else {
    return '';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品詳細</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="image-row">
        <?= imageTag($product['image1']) ?>
        <?= imageTag($product['image2']) ?>
        <?= imageTag($product['image3']) ?>
    </div>

    <input type="text" value="<?= h($product['bookname']) ?>" readonly>
    <input type="text" value="¥<?= h($product['price']) ?>" readonly>

    <label>説明文</label>
    <textarea readonly><?= h($product['descript']) ?></textarea>

    <div class="button-row">
      <a href="javascript:history.back()" class="detail-btn">戻る</a>
      <button class="detail-btn" onclick="confirmPurchase(<?= h($product['ID']) ?>)">購入する</button>
    </div>

    <script>
    function confirmPurchase(productId) {
      if (confirm('本当に購入しますか？')) {
        window.location.href = 'buy.php?id=' + productId;
      }
    }
    </script>
</body>
</html>
