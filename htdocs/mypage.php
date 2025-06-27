<?php
// DB接続
$dbServer = '127.0.0.1';
$dbUser   = $_SERVER['MYSQL_USER']     ?? 'testuser';
$dbPass   = $_SERVER['MYSQL_PASSWORD'] ?? 'pass';
$dbName   = $_SERVER['MYSQL_DB']       ?? 'mydb';

$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "DB接続失敗: " . htmlspecialchars($e->getMessage());
  exit();
}

$user_id = 1; // ログインしている仮のユーザーID

// 出品データ取得
$sql = "SELECT product_ID, image1, image2, image3 FROM products WHERE user_ID = :user_id ORDER BY product_ID DESC LIMIT 10";
$stmt = $db->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>マイページ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>出品</h2>
    <div class="scroll-container">
      <?php foreach ($products as $product): ?>
        <?php for ($i=1; $i<=3; $i++): ?>
          <?php if (!empty($product["image$i"])): ?>
            <?php
              $base64 = base64_encode($product["image$i"]);
              $src = "data:image/jpeg;base64," . $base64;
            ?>
            <div class="image-box">
              <img src="<?= $src ?>" alt="出品商品<?= htmlspecialchars($product['product_ID']) ?>">
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      <?php endforeach; ?>
    </div>

    <h2>取引</h2>
    <div class="scroll-container">
      <!-- 取引データの表示はここに必要に応じて同様に実装 -->
    </div>

    <form action="home.php" method="get">
      <button class="return-btn">戻る</button>
    </form>
  </div>
</body>
</html>
