<?php
require 'db.php'; // データベース接続を含むファイルをインクルード

if (!isset($db)) {
    die("Database connection not established.");
}

$err_msg = ''; // エラーメッセージ変数の初期化

$user = $_POST["username"];
$pass = $_POST["password"];



if ($user && $pass) {
    $sql = 'SELECT * FROM department WHERE gakka ='.'"'.$user.'"';
    $prepare = $db->prepare($sql);
    $prepare->execute();
    $result = $prepare->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $db_user = $result['username'];
        $db_pass = $result['password'];
        if (($db_user == $user) && password_verify($pass, $db_pass)) {
            session_start();
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user_name'] = $result['username'];
            $_SESSION['department_name'] = $result['department'];
            header("Location:menu.php");
            exit();
        } else {
            $err_msg = "ユーザ名またはパスワードが間違っています。";
            header("Location:index.php?error=blank");
        }
    } else {
        $err_msg = "ユーザ名が間違ってます。";
        header("Location:index.php?error=brank");
    }
}
?>