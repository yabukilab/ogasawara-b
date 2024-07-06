<?php
session_start();
require 'db2.php';

// 登録した学科を取得
$department = isset($_GET['dept']) ? $_GET['dept'] : '';

if (empty($department)) {
    echo "<div style='color: red;'>学科が選択されていません。</div>";
    exit();
}

// 学科名を取得する
$departments = [
    'ut' => '宇宙・半導体工学科',
    'sen' => '先端材料工学科',
    'den' => '電気電子工学科',
    'jo' => '情報通信システム工学科',
    'ouyo' => '応用化学科',
    'ken' => '建築学科',
    'tosi' => '都市環境工学科',
    'deza' => 'デザイン科学科',
    'seimei' => '生命科学科',
    'tinome' => '知能メディア学科',
    'jouhou' => '情報工学科',
    'ninti' => '認知情報科学科',
    'koudo' => '高度応用情報科学科',
    'dejihen' => 'デジタル変革科学科',
    'keideza' => '経営デザイン科学科',
    'net' => '情報ネットワーク学科',
    'keijou' => '経営情報科学科',
    'pm' => 'プロジェクトマネジメント学科',
    'kinyuu' => '金融・経営リスク科学科'
];

$department_name = $departments[$department] ?? '';

if (empty($department_name)) {
    echo "<div style='color: red;'>無効な学科が選択されています。</div>";
    exit();
}

// 掲示板データを取得
$sql = 'SELECT * FROM boards WHERE department = :department ORDER BY date DESC';
$stmt = $db->prepare($sql);
$stmt->bindParam(':department', $department, PDO::PARAM_STR);
$stmt->execute();
$boards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($department_name); ?>の掲示板</title>
    <link rel="stylesheet" href="st4.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($department_name); ?>の掲示板</h1>
    <div class="board-container">
        <?php if (count($boards) > 0): ?>
            <?php foreach ($boards as $index => $board): ?>
                <div class="board-post">
                    <h2><?php echo htmlspecialchars($index + 1) . '. ' . htmlspecialchars($board['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($board['content'])); ?></p>
                    <span>投稿者: <?php echo htmlspecialchars($board['author']); ?></span>
                    <span>投稿日: <?php echo htmlspecialchars($board['date']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>掲示板にはまだ投稿がありません。</p>
        <?php endif; ?>
    </div>
</body>
</html>
