<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $faculty = $_POST['faculty'] ?? '';
    $department = $_POST['department'] ?? '';

    if ($username && $password && $faculty && $department) {
        // 同一ユーザ名の確認
        $sql = 'SELECT COUNT(*) FROM users WHERE username = :username';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "<div style='color: red;'>このユーザ名は既に使用されています。</div>";
        } else {
            // パスワードのハッシュ化
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 新規ユーザ登録
            $sql = 'INSERT INTO users (username, password, faculty, department) VALUES (:username, :password, :faculty, :department)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':faculty', $faculty, PDO::PARAM_STR);
            $stmt->bindParam(':department', $department, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: index.php");
            exit();
        }
    } else {
        echo "<div style='color: red;'>すべてのフィールドに入力してください</div>";
    }
}
?>
