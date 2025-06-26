<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // 通報テーブルから mailaddress を取得
    $stmt = $db->prepare("SELECT mailaddress FROM reporting WHERE id = ?");
    $stmt->execute([$id]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($report && isset($report['mailaddress'])) {
        $mail = $report['mailaddress'];

        // デバッグ（必要なら）
        // var_dump($mail); exit;

        // 正しいテーブル名＆カラム名を使用
        $stmtUser = $db->prepare("DELETE FROM users WHERE email = ?");
        $stmtUser->execute([$mail]);

        // 通報削除
        $stmtDelete = $db->prepare("DELETE FROM reporting WHERE id = ?");
        $stmtDelete->execute([$id]);
    } else {
        echo "該当する通報が見つかりません";
        exit;
    }
}

header("Location: report_list.php");
exit;