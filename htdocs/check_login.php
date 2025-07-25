<?php
session_start();
require 'db_connect.php'; // ← ここで接続

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
  // ログイン成功
  $_SESSION['user_ID'] = $user['ID'];
  
  // 管理者判断
  if ($email === 'admin@example.com' && $password === 'adminpass') {
    header("Location: report_list.php");
    exit;
  }
  
  header("Location: home.php"); // ログイン後のページ
  exit;
} else {
  // ログイン失敗
  header("Location: login_failed.php");
  exit;
}