<?php
require 'db.php'; // データベース接続を含むファイルをインクルード

if (!isset($db)) {
    die("Database connection not established.");
}

$err_msg = ''; // エラーメッセージ変数の初期化

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';

    if ($user && $pass) {
        $sql = 'SELECT * FROM users WHERE username ='.'"'.$user.'"';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $db_pass = $result['password'];
            if (password_verify($pass, $db_pass)) {
                session_start();
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['user_name'] = $result['username'];
                $_SESSION['department_name'] = $result['department'];
                header("Location: menu.php");
                exit();
            } else {
                $err_msg = "ユーザ名またはパスワードが間違っています。";
            }
        } else {
            $err_msg = "ユーザ名またはパスワードが間違っています。";
        }
    } else {
        $err_msg = "ユーザ名とパスワードを入力してください。";
    }
}
?>

