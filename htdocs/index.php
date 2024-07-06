<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="st.css">
</head>

<body>
    <h1>ログイン</h1>
    <form action="check.php" method="POST">
        <?php if (isset($err_msg) && $err_msg !== ""): ?>
            <div style="color: red;"><?php echo htmlspecialchars($err_msg, ENT_QUOTES, 'UTF-8'); ?></div><br>
        <?php endif; ?>
        <div class="name">
            ユーザ名<input type="text" name="username"><br>
        </div>
        <div class="password">
            パスワード<input type="password" name="password"><br>
        </div>
        <input type="submit" name="Login" class="button" value="ログイン">
    </form>
    <a href="signin.php">新規登録</a>
</body>

</html>
