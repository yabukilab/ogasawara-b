<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>新規登録</h2>

        <form action="register_done.php" method="post">
            <label>メールアドレス</label>
            <input type="email" name="email" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <label>確認パスワード</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" class="login-btn">登録</button>
        </form>

        <a href="index.php" class="return-btn">戻る</a>
    </div>
</body>
</html>
