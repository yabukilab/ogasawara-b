<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_ID'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_ID'];

// 出品欄：自分が出品していて未購入のもの（bflag=0）
$sql1 = "SELECT ID, image1, image2, image3 FROM products 
         WHERE user_ID = :user_id AND bflag = 0
         ORDER BY ID DESC LIMIT 10";
$stmt1 = $db->prepare($sql1);
$stmt1->execute([':user_id' => $user_id]);
$products_selling = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// 取引欄：購入済みで、自分が出品者か購入者になっている商品（bflag=1）
$sql2 = "SELECT ID, image1, image2, image3, user_ID, buyer_ID FROM products 
         WHERE bflag=1 AND (user_ID = :user_id1 OR buyer_ID = :user_id2)
         ORDER BY ID DESC LIMIT 10";
$stmt2 = $db->prepare($sql2);
$stmt2->execute([
  ':user_id1' => $user_id,
  ':user_id2' => $user_id
]);
$products_dealing = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
      <?php foreach ($products_selling as $product): ?>
        <?php for ($i=1; $i<=3; $i++): ?>
          <?php if (!empty($product["image$i"])): ?>
            <?php
              $base64 = base64_encode($product["image$i"]);
              $src = "data:image/jpeg;base64," . $base64;
            ?>
            <div class="image-box">
              <a href="detail.php?id=<?= htmlspecialchars($product['ID']) ?>">
                <img src="<?= $src ?>" alt="出品商品ID<?= htmlspecialchars($product['ID']) ?>">
              </a>
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      <?php endforeach; ?>
    </div>

    <h2>取引</h2>
    <div class="scroll-container">
      <?php foreach ($products_dealing as $product): ?>
        <?php
          // 出品者としての取引か、購入者としての取引かを判別
          $role = ($product['user_ID'] == $user_id) ? '出品者' : '購入者';
        ?>
        <?php for ($i=1; $i<=3; $i++): ?>
          <?php if (!empty($product["image$i"])): ?>
            <?php
              $base64 = base64_encode($product["image$i"]);
              $src = "data:image/jpeg;base64," . $base64;
            ?>
            <div class="image-box">
              <img src="<?= $src ?>" alt="取引商品ID<?= htmlspecialchars($product['ID']) ?>">
              <p style="text-align:center; font-size:12px;"><?= $role ?></p>
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      <?php endforeach; ?>
    </div>

    <form action="home.php" method="get">
      <button class="turn_home-btn">戻る</button>
    </form>
  </div>
</body>
</html>
