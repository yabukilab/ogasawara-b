<?php
require 'db_connect.php';
$stmt = $db->query("SELECT * FROM reporting");
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>通報リスト</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>通報リスト</h1>

        <?php foreach ($reports as $report): ?>
            <div class="report-item">
                <div class="report-text">
                    <div class="email"><?= htmlspecialchars($report['mailaddress']) ?></div>
                    <div class="reason"><?= nl2br(htmlspecialchars($report['reason'])) ?></div>
                </div>
                <form method="post" action="delete_report.php" class="delete-form">
<input type="hidden" name="id" value="<?= $report['ID'] ?>">
                    <button type="submit" class="delete-btn">×</button>
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</body>

</html>