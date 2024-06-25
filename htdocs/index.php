<?php
require 'db.php'; // データベース接続を含むファイルをインクルード

if (!isset($db)) {
    // データベース接続が確立されていない場合の処理
    die("Database connection not established.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // フォームがPOSTリクエストで送信されたかどうかを確認
    // フォームからデータを取得
    $user = $_POST["username"] ?? ''; // ユーザ名を取得、未設定の場合は空文字をセット
    $pass = $_POST["password"] ?? ''; // パスワードを取得、未設定の場合は空文字をセット

    // データの検証（空でないかチェック）
    if ($user && $pass) {
        // ユーザ名とパスワードのチェック
        $sql = 'SELECT * FROM users WHERE username = :username'; // SQLクエリを準備
        $prepare = $db->prepare($sql); // クエリを準備
        $prepare->bindParam(':username', $user, PDO::PARAM_STR); // ユーザ名をクエリにバインド
        $prepare->execute(); // クエリを実行
        $result = $prepare->fetch(PDO::FETCH_ASSOC); // 結果を連想配列として取得

        if ($result) { // ユーザが見つかった場合
            $db_pass = $result['password']; // データベースから取得したパスワードを取得
            if (password_verify($pass, $db_pass)) { // パスワードがハッシュ化されている場合、検証
                // ログイン成功
                session_start(); // セッションを開始
                $_SESSION['user_id'] = $result['id']; // ユーザIDをセッションに保存
                $_SESSION['username'] = $user; // ユーザ名をセッションに保存
                // menu.phpにリダイレクト
                header("Location: menu.php"); // menu.phpにリダイレクト
                exit(); // スクリプトを終了
            } else {
                // パスワードが一致しない
                $err_msg = "ユーザ名またはパスワードが間違っています。"; // エラーメッセージをセット
            }
        } else {
            // ユーザ名が見つからない
            $err_msg = "ユーザ名またはパスワードが間違っています。"; // エラーメッセージをセット
        }
    } else {
        $err_msg = "ユーザ名とパスワードを入力してください。"; // エラーメッセージをセット
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css"> <!-- スタイルシートをリンク -->
</head>

<body>

    <h1>ログイン</h1>
    <form action="" method="POST"> <!-- フォームの開始、POSTメソッドを使用 -->
        <?php if (isset($err_msg) && $err_msg !== "") { // エラーメッセージが設定されている場合
                echo "<div style='color: red;'>$err_msg</div><br>"; // エラーメッセージを表示
            } ?>
        <div class="name">
            ユーザ名<input type="text" name="username" value=""><br> <!-- ユーザ名入力フィールド -->
        </div>
        <div class="password">
            パスワード<input type="password" name="password" value=""><br> <!-- パスワード入力フィールド -->
        </div>
        <input type="submit" name="Login" class="button" value="ログイン"> <!-- ログインボタン -->
    </form>

    <a href="signin.php">新規登録</a> <!-- 新規登録ページへのリンク -->

</body>

</html>