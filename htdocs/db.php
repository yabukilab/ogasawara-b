// db.php
<?php

# HTMLでのエスケープ処理をする関数（データベースとは無関係だが，ついでにここで定義しておく．）
# この関数は、HTMLでのエスケープ処理を行うためのものです。クロスサイトスクリプティング（XSS）対策として使用します。
function h($var)
{
  if (is_array($var)) { // 変数が配列の場合、配列の各要素に対して再帰的にこの関数を適用
    return array_map('h', $var);
  } else {
    // htmlspecialchars関数を使って、特殊文字をHTMLエンティティに変換
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

# データベース接続情報の設定
$dbServer = '127.0.0.1'; // データベースサーバーのホスト名
$dbUser = isset($_SERVER['MYSQL_USER']) ? $_SERVER['MYSQL_USER'] : 'testuser'; // 環境変数 'MYSQL_USER' が設定されていればその値を使用、なければ 'testuser' を使用
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass'; // 環境変数 'MYSQL_PASSWORD' が設定されていればその値を使用、なければ 'pass' を使用
$dbName = isset($_SERVER['MYSQL_DB']) ? $_SERVER['MYSQL_DB'] : 'mydb'; // 環境変数 'MYSQL_DB' が設定されていればその値を使用、なければ 'mydb' を使用

# データベースソースネーム（DSN）の設定
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8"; // DSNにはデータベースの種類、ホスト名、データベース名、文字セットを含める

try {
  # PDOオブジェクトの作成
  $db = new PDO($dsn, $dbUser, $dbPass); // DSN、ユーザー名、パスワードを使ってPDOインスタンスを作成
  # プリペアドステートメントのエミュレーションを無効にする．
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // プリペアドステートメントのエミュレーションを無効にすることで、セキュリティを向上
  # エラー→例外
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外に設定し、エラー発生時に例外をスローするようにする
} catch (PDOException $e) {
  # データベース接続エラー時の処理
  echo "Can't connect to the database: " . h($e->getMessage()); // 接続エラーが発生した場合、エラーメッセージをエスケープして表示
  exit(); // スクリプトを終了
}
