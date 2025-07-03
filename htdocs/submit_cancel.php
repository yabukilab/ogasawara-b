<?php
require 'db_connect.php';

$mail = $_POST['mailaddress'] ?? '';
$reason = $_POST['reason'] ?? '';

if (trim($mail) === '' || trim($reason) === '') {
    die('入力エラー');
}

$stmt = $db->prepare("INSERT INTO reporting (mailaddress, reason) VALUES (:mail, :reason)");
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':reason', $reason);
$stmt->execute();

// 通報リストへ遷移
header("Location: report_list.php");
exit;