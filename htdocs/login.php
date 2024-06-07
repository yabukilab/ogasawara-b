<?php
// データベース接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample";

// エラーメッセージの初期化
$err_msg = "";

// 接続を作成
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';

    // データの検証（空でないかチェック）
    if ($user && $pass) {
        // ユーザ名とパスワードのチェック
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($db_pass);
        $stmt->fetch();
        $stmt->close();

        if ($db_pass) {
            if (password_verify($pass, $db_pass)) { // パスワードがハッシュ化されている場合
                // ログイン成功
                echo "ログイン成功";
                // セッションを開始
                session_start();
                $_SESSION['username'] = $user;
                // keijiban.phpにリダイレクト
                header("Location: http://localhost/PMensyuu/keijiban.php");
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

$conn->close();
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
        <?php if ($err_msg !== "") {
            echo "<div style='color: red;'>$err_msg</div><br>";
        } ?>
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