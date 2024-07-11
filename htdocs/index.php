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
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'blank'): ?>
            <div style="color : red; font-weight:bold;">ユーザ名またはパスワードが間違っています</div>
        <?php endif; ?>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'brank'): ?>
            <div style="color : red; font-weight:bold;">ユーザ名が間違っています</div>
        <?php endif; ?>
        <div class="name" style="font-size: 20px;">
            ユーザ名<input type="text" name="username" required><br>
        </div>
        <div class="password" style="font-size:20px;">
            パスワード<input type="password" name="password" required><br>
        </div>
        <div class="loginbutton">
            <input type="submit" name="Login" class="button" value="ログイン">
        </div>
    </form>
    <div class="sinkibotan">
        <a href="signin.php">新規登録</a>
    </div>
</body>
</html>