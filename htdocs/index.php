<?php
require 'db.php'; // データベース接続情報を含むファイルをインクルード

session_start();

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
                $_SESSION['user_id'] = $result['id']; // ユーザIDをセッションに保存
                $_SESSION['username'] = $user; // ユーザ名をセッションに保存
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

// ユーザ一覧の表示処理
try {
    $stmt = $db->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . h($e->getMessage());
    exit;
}

// ユーザ情報の更新処理
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'] ?? null;
    $username = $_POST["username"] ?? '';
    $faculty = $_POST["faculty"] ?? '';
    $department = $_POST["department"] ?? '';

    if ($username && $faculty && $department && $id) {
        try {
            $stmt = $db->prepare("UPDATE users SET username = ?, faculty = ?, department = ? WHERE id = ?");
            $stmt->execute([$username, $faculty, $department, $id]);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            echo "エラー: " . h($e->getMessage());
        }
    } else {
        $err_msg = "全てのフィールドを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ユーザ管理</title>
    <link rel="stylesheet" href="st2.css">
</head>

<body>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <h1>ログイン</h1>
        <form action="" method="POST">
            <?php if (isset($err_msg) && $err_msg !== "") {
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
    <?php else: ?>
        <h1>ユーザ一覧</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>ユーザ名</th>
                <th>学部</th>
                <th>学科</th>
                <th>操作</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo h($user['id']); ?></td>
                    <td><?php echo h($user['username']); ?></td>
                    <td><?php echo h($user['faculty']); ?></td>
                    <td><?php echo h($user['department']); ?></td>
                    <td><a href="index.php?edit=<?php echo h($user['id']); ?>">編集</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php if (isset($_GET['edit'])):
            $edit_id = $_GET['edit'];
            try {
                $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$edit_id]);
                $edit_user = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "エラー: " . h($e->getMessage());
                exit;
            }
            ?>
            <h2>ユーザ編集</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo h($edit_user['id']); ?>">
                <table>
                    <tr>
                        <td><label for="username">ユーザ名</label></td>
                        <td><input type="text" name="username" id="username" value="<?php echo h($edit_user['username']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td><label for="faculty">学部</label></td>
                        <td>
                            <select class="mainselect" name="faculty" id="faculty" required>
                                <option value="">学部を選択</option>
                                <option value="kougaku" <?php if ($edit_user['faculty'] == 'kougaku')
                                    echo 'selected'; ?>>工学部
                                </option>
                                <option value="souzou" <?php if ($edit_user['faculty'] == 'souzou')
                                    echo 'selected'; ?>>創造工学部
                                </option>
                                <option value="senshin" <?php if ($edit_user['faculty'] == 'senshin')
                                    echo 'selected'; ?>>先進工学部
                                </option>
                                <option value="jouhenkaku" <?php if ($edit_user['faculty'] == 'jouhenkaku')
                                    echo 'selected'; ?>>
                                    情報変革科学部</option>
                                <option value="mirai" <?php if ($edit_user['faculty'] == 'mirai')
                                    echo 'selected'; ?>>未来変革科学部
                                </option>
                                <option value="jouhou" <?php if ($edit_user['faculty'] == 'jouhou')
                                    echo 'selected'; ?>>情報科学部
                                </option>
                                <option value="shakai" <?php if ($edit_user['faculty'] == 'shakai')
                                    echo 'selected'; ?>>社会システム科学部
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="department">学科</label></td>
                        <td>
                            <select name="department" id="department" class="subbox" required>
                                <option value="">学科を選択</option>
                                <option value="department1" <?php if ($edit_user['department'] == 'department1')
                                    echo 'selected'; ?>>学科1</option>
                                <option value="department2" <?php if ($edit_user['department'] == 'department2')
                                    echo 'selected'; ?>>学科2</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="update" value="更新">
            </form>
        <?php endif; ?>
    <?php endif; ?>

</body>

</html>