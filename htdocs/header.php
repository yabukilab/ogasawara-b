<?php
// header.php

// セッションを開始し、ユーザがログインしているか確認
session_start();

// データベース接続ファイルをインクルード
require 'db.php';

// セッションからユーザIDを取得
$user_id = $_SESSION['user_id'];

// ユーザ情報を取得するためのSQL準備と実行
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザが見つからなければエラーメッセージを表示して終了
if (!$user) {
    echo "ユーザが見つかりません。";
    exit;
}

// 学科情報に応じたリンクを表示
$department = $user['department'];
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="st3.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.php">ホーム</a></li>
            <?php if ($department == 'ut'): ?>
                <li><a href="ut_board.php">宇宙・半導体工学科掲示板</a></li>
            <?php elseif ($department == 'cs'): ?>
                <li><a href="cs_board.php">コンピュータサイエンス掲示板</a></li>
            <?php elseif ($department == 'bio'): ?>
                <li><a href="bio_board.php">生物学科掲示板</a></li>
            <?php else: ?>
                <li><a href="general_board.php">一般掲示板</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>

</html>