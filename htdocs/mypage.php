<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_ID'])) {
  header("Location: login.php"); // 未ログインはログインページへ
  exit;
}

$user_id = $_SESSION['user_ID'];

// 出品データ取得
$sql = "SELECT ID, image1, image2, image3 FROM products WHERE user_ID = :user_id ORDER BY ID DESC LIMIT 10";
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
              <img src="<?= $src ?>" alt="出品商品ID<?= htmlspecialchars($product['ID']) ?>">
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      <?php endforeach; ?>
    </div>

    <h2>取引</h2>
    <div class="scroll-container">
      <!-- 必要に応じて取引情報も同様に実装 -->
    </div>

    <form action="home.php" method="get">
      <button class="return-btn">戻る</button>
    </form>
  </div>
</body>
</html>
