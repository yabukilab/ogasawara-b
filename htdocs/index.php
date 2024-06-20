<?php
 require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';

    // データの検証（空でないかチェック）
    if ($user && $pass) {
        // ユーザ名とパスワードのチェック
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($user_id, $db_pass);
        $stmt->fetch();
        $stmt->close();

        if ($db_pass) {
            if (password_verify($pass, $db_pass)) { // パスワードがハッシュ化されている場合
                // ログイン成功
                session_start();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $user;
                // menu.phpにリダイレクト
                header("Location: menu.php");
                exit();
            } else {
                // パスワードが一致しない
                $err_msg = "ユーザ名またはパスワードが間違っています。";
            }
        } else {
            // ユーザ名が見つからない
            $err_msg = "ユーザ名またはパスワードが間違っています。";
        }
    } else {
        $err_msg = "全てのフィールドを入力してください。";
    }
}

//$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>ログイン</h1>
    <form action="" method="POST">
        <!--<?php if ($err_msg !== "") {
            echo "<div style='color: red;'>$err_msg</div><br>";
        } ?>-->
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
