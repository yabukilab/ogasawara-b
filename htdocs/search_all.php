<?php
require 'db.php'; // データベース接続情報を含むファイルをインクルード

try {
    $stmt = $db->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . h($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ユーザ一覧</title>
    <link rel="stylesheet" href="st2.css">
</head>

<body>
    <h1>ユーザ一覧</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ユーザ名</th>
            <th>学部</th>
            <th>学科</th>
            <th>操作</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo h($user['id']); ?></td>
                <td><?php echo h($user['username']); ?></td>
                <td><?php echo h($user['faculty']); ?></td>
                <td><?php echo h($user['department']); ?></td>
                <td><a href="update_record.php?id=<?php echo h($user['id']); ?>">編集</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>