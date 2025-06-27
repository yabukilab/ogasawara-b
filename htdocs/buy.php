<?php
function h($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

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

// 商品ID取得
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    // bflagを1に更新
    $stmt = $db->prepare("UPDATE products SET bflag = 1 WHERE ID = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // チャット画面に遷移（商品ID付き）
    header("Location: chat.php?id={$id}");
    exit();
} else {
    echo "不正なアクセスです";
}
