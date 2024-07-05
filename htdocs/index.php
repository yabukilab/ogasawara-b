<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="st.css">

</head>

<body>
    <h1>ログイン</h1>
    <form action="" method="POST">
        <?php if (isset($err_msg) && $err_msg !== ""): ?>
            <div style="color: red;"><?php echo htmlspecialchars($err_msg, ENT_QUOTES, 'UTF-8'); ?></div><br>
        <?php endif; ?>
        <div class="name">
            ユーザ名<input type="text" name="username" value=""><br>
        </div>
        <div class="password">
            パスワード<input type="password" name="password" value=""><br>
        </div>
        <input type="submit" name="Login" class="button" value="ログイン">
    </form>
    <a href="signin.php">新規登録</a>
</body>

</html>

<?php
require 'db2.php'; // データベース接続を含むファイルをインクルード

if (!isset($db)) {
    die("Database connection not established.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';

    if ($user && $pass) {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $prepare = $db->prepare($sql);
        $prepare->bindParam(':username', $user, PDO::PARAM_STR);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $db_pass = $result['password'];
            if (password_verify($pass, $db_pass)) {
                session_start();
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $user;
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