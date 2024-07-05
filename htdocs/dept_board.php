<?php
require 'db2.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$dept = $_GET['dept'] ?? '';

$allowed_departments = [
    'zen' => 0,
    'ut' => 1,
    'sen' => 2,
    'den' => 3,
    'jo' => 4,
    'ouyo' => 5,
    'ken' => 6,
    'tosi' => 7,
    'deza' => 8,
    'seimei' => 9,
    'tinome' => 10,
    'jouhou' => 11,
    'ninti' => 12,
    'koudo' => 13,
    'dejihen' => 14,
    'keideza' => 15,
    'net' => 16,
    'keijou' => 17,
    'pm' => 18,
    'kinyuu' => 19
];

if ($dept !== 'all' && (!isset($allowed_departments[$dept]) || $_SESSION['department_id'] != $allowed_departments[$dept])) {
    echo "この掲示板にアクセスする権限がありません。";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>掲示板</title>
    <link rel="stylesheet" href="st3.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?>掲示板</h1>
    <!-- 掲示板の内容をここに表示 -->
</body>
</html>
