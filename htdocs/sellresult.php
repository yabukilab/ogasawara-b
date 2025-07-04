<?php
session_start();

function h($v) {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
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

// 入力値取得
$bookname = $_POST['bookname'] ?? '';
$price    = $_POST['price']    ?? 0;
$descript = $_POST['descript'] ?? '';
$user_id  = $_SESSION['user_ID'] ?? null;
if (!$user_id) {
  echo "ログイン情報が見つかりません";
  exit();
}

$image1 = !empty($_FILES['image1']['tmp_name']) ? file_get_contents($_FILES['image1']['tmp_name']) : null;
$image2 = !empty($_FILES['image2']['tmp_name']) ? file_get_contents($_FILES['image2']['tmp_name']) : null;
$image3 = !empty($_FILES['image3']['tmp_name']) ? file_get_contents($_FILES['image3']['tmp_name']) : null;

// ▼ image1が未指定ならエラー画面表示して終了
if (!$image1) {
  ?>
  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>出品エラー</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .error-container {
        max-width: 400px;
        margin: 100px auto;
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
      }
      .error-message {
        color: red;
        font-size: 16px;
        margin: 20px 0;
      }
      .back-btn {
        background-color: #555;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <div class="error-container">
      <p class="error-message">画像を最低1枚登録してください</p>
      <a href="javascript:history.back()" class="back-btn">戻る</a>
    </div>
  </body>
  </html>
  <?php
  exit();
}

// 登録処理
$sql = "INSERT INTO products (bookname, price, descript, image1, image2, image3, user_ID, bflag)
        VALUES (:bookname, :price, :descript, :image1, :image2, :image3, :user_ID, 0)";
$stmt = $db->prepare($sql);
$stmt->execute([
  ':bookname' => $bookname,
  ':price'    => $price,
  ':descript' => $descript,
  ':image1'   => $image1,
  ':image2'   => $image2,
  ':image3'   => $image3,
  ':user_ID'  => $user_id,
]);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="5;url=home.php">
  <title>出品完了</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .result-container {
      max-width: 400px;
      margin: 100px auto;
      text-align: center;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
    }

    .result-container p {
      margin: 20px 0;
      font-size: 16px;
    }

    .result-container .highlight {
      font-weight: bold;
      font-size: 18px;
    }

    .home-btn {
      background-color: #005b82;
      color: white;
      padding: 15px 25px;
      font-size: 16px;
      border: none;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      cursor: pointer;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="result-container">
    <p>出品しました</p>
    <p class="highlight">5秒後にホーム画面に戻ります</p>
    <a href="home.php" class="home-btn">ホーム画面に戻る</a>
  </div>
</body>
</html>