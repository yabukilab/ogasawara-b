<?php
<<<<<<< HEAD

# HTMLでのエスケープ処理をする関数（データベースとは無関係だが，ついでにここで定義しておく．）
# 引数に渡された変数をHTMLエスケープする関数
=======
>>>>>>> e26b3c524253e8216873d0a18a72ba1e7392b021
function h($var)
{
  if (is_array($var)) {
    # 配列の場合は再帰的に処理する
    return array_map('h', $var);
  } else {
    # 配列でない場合はhtmlspecialchars関数を使ってエスケープ処理する
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

<<<<<<< HEAD
# データベース接続に必要な情報を設定
$dbServer = '127.0.0.1'; # データベースサーバのホスト名
$dbUser = isset($_SERVER['MYSQL_USER']) ? $_SERVER['MYSQL_USER'] : 'root'; # データベースユーザ名
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : '';    # データベースパスワード
$dbName = isset($_SERVER['MYSQL_DB']) ? $_SERVER['MYSQL_DB'] : 'mydb'; # データベース名
=======
$dbServer = isset($_ENV['MYSQL_SERVER']) ? $_ENV['MYSQL_SERVER'] : '127.0.0.1';
$dbUser = isset($_SERVER['MYSQL_USER']) ? $_SERVER['MYSQL_USER'] : 'root';
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : '';
$dbName = isset($_SERVER['MYSQL_DB']) ? $_SERVER['MYSQL_DB'] : 'mydb';
>>>>>>> e26b3c524253e8216873d0a18a72ba1e7392b021

# DSN (Data Source Name) の設定
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
  # PDO (PHP Data Objects) インスタンスの作成
  $db = new PDO($dsn, $dbUser, $dbPass);
<<<<<<< HEAD
  # プリペアドステートメントのエミュレーションを無効にする
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  # エラー発生時に例外をスローするように設定
=======
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
>>>>>>> e26b3c524253e8216873d0a18a72ba1e7392b021
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  # データベース接続に失敗した場合はエラーメッセージを表示する
  echo "Can't connect to the database: " . h($e->getMessage());
<<<<<<< HEAD
}

# ここに続くコードはデータベース接続が成功した後の処理を記述
?>

}
=======
  exit;
}
?>
>>>>>>> e26b3c524253e8216873d0a18a72ba1e7392b021
