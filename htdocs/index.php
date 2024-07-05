<?php
require 'db2.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $sql = 'SELECT * FROM users WHERE name = :username';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['department_id'] = $user['department_id'];
            header("Location: menu.php");
            exit();
        } else {
            $error_message = "ユーザ名またはパスワードが間違っています。";
        }
    } else {
        $error_message = "すべてのフィールドに入力してください。";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="st3.css">
</head>
<body>
    <h1>ログイン</h1>
    <form method="POST" action="">
        <?php if (isset($error_message)): ?>
            <div style="color: red;"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <div>
            <label for="username">ユーザ名</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <input type="submit" value="ログイン">
        </div>
    </form>
</body>
</html>
