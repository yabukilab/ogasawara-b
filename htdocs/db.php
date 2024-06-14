<?php
$host = 'localhost';
$db = 'sample';
$user = 'root'; // 適切なユーザー名
$pass = ''; // 適切なパスワード

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
keijiban/
├── db.php
├── all_board.php
├── dept_board.php
├── header.php
└── footer.php
