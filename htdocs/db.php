<?php

# HTMLでのエスケープ処理をする関数
function h($var)
{
  if (is_array($var)) {
    return array_map('h', $var);
  } else {
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

# データベース接続情報の設定
$dbServer = '127.0.0.1'; // データベースサーバーのホスト名
$dbUser = 'testuser'; // データベースユーザー名
$dbPass = 'pass'; // データベースパスワード
$dbName = 'mydb'; // データベース名

# データベースソースネーム（DSN）の設定
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
  # PDOオブジェクトの作成
  $db = new PDO($dsn, $dbUser, $dbPass);
  # プリペアドステートメントのエミュレーションを無効にする
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  # エラーモードを例外に設定
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  # データベース接続エラー時の処理
  echo "Can't connect to the database: " . h($e->getMessage());
  exit();
}
?>