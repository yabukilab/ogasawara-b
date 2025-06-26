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
      <?php
        // 最大10枚出品画像（仮データ）
        for ($i = 1; $i <= 10; $i++) {
          echo "<div class='image-box'><img src='sample_item_$i.jpg' alt='出品商品$i'></div>";
        }
      ?>
    </div>

    <h2>取引</h2>
    <div class="scroll-container">
      <?php
        // 最大3枚取引画像（仮データ）
        for ($i = 1; $i <= 3; $i++) {
          echo "<div class='image-box'><img src='deal_item_$i.jpg' alt='取引商品$i'></div>";
        }
      ?>
    </div>

    <form action="home.php" method="get">
      <button class="return-btn">戻る</button>
    </form>
  </div>
</body>
</html>