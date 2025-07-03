<?php
# HTMLエスケープ関数
function h($var) {
  if (is_array($var)) {
    return array_map('h', $var);
  } else {
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

# DB接続
$dbServer = '127.0.0.1';
$dbUser = isset($_SERVER['MYSQL_USER'])     ? $_SERVER['MYSQL_USER']     : 'testuser';
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass';
$dbName = isset($_SERVER['MYSQL_DB'])       ? $_SERVER['MYSQL_DB']       : 'mydb';

$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
  $db = new PDO($dsn, $dbUser, $dbPass);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Can't connect to the database: " . h($e->getMessage());
  exit();
}

# 検索キーワード取得
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

# 商品検索SQL
$sql = "SELECT ID, bookname, price, image1 FROM products WHERE bflag = 0";
if (!empty($searchQuery)) {
  $sql .= " AND (bookname LIKE :q1 OR descript LIKE :q2)";
}

$stmt = $db->prepare($sql);
if (!empty($searchQuery)) {
  $stmt->bindValue(':q1', '%' . $searchQuery . '%');
  $stmt->bindValue(':q2', '%' . $searchQuery . '%');
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>中古教科書検索結果</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
    <h2>商品検索</h2>
    <form method="GET" action="">
        <input type="text" name="query" placeholder="商品名で検索" value="<?php echo h($searchQuery); ?>">
        <button type="submit" class="search-btn">検索</button>
    </form>
    
    <form action="home.php" method="get">
      <button class="return-btn">戻る</button>
    </form>

    <div class="products">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <a href="detail.php?id=<?= h($product['ID']) ?>">
                    <?php if (!empty($product['image1'])): ?>
                        <?php
                            $imgData = base64_encode($product['image1']);
                            $src = "data:image/jpeg;base64,{$imgData}";
                        ?>
                        <img src="<?php echo $src; ?>" alt="商品画像">
                    <?php else: ?>
                        <div class="no-img">画像なし</div>
                    <?php endif; ?>
                </a>
                <div class="product-price">¥<?= h($product['price']) ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>商品が見つかりませんでした。</p>
    <?php endif; ?>
    </div>
</div>
</body>
</html>
