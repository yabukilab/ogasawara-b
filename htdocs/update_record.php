<?php
require 'db2.php'; // データベース接続情報を含むファイルをインクルード

$id = $_GET['id'] ?? null;
if ($id === null) {
    echo "エラー: IDが指定されていません。";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $username = $_POST["username"] ?? '';
    $faculty = $_POST["faculty"] ?? '';
    $department = $_POST["department"] ?? '';

    // データの検証（空でないかチェック）
    if ($username && $faculty && $department) {
        try {
            // SQLインジェクションを防ぐためにプリペアドステートメントを使用
            $stmt = $db->prepare("UPDATE users SET username = ?, faculty = ?, department = ? WHERE id = ?");
            $stmt->execute([$username, $faculty, $department, $id]);

            // 更新が完了したらリダイレクト
            header("Location: ./search_all.php");
            exit();
        } catch (PDOException $e) {
            echo "エラー: " . h($e->getMessage());
        }
    } else {
        echo "全てのフィールドを入力してください。";
    }
} else {
    // 更新フォームのためのユーザ情報を取得
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "エラー: ユーザが見つかりません。";
            exit;
        }
    } catch (PDOException $e) {
        echo "エラー: " . h($e->getMessage());
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ユーザ編集</title>
    <link rel="stylesheet" href="st2.css">
</head>

<body>
    <h1>ユーザ編集</h1>
    <form action="" method="POST">
        <!-- User update fields -->
        <table>
            <tr>
                <td><label for="username">ユーザ名</label></td>
                <td><input type="text" name="username" id="username" value="<?php echo h($user['username']); ?>"
                        required></td>
            </tr>
            <tr>
                <td><label for="faculty">学部</label></td>
                <td>
                    <select class="mainselect" name="faculty" id="faculty" required>
                        <option value="">学部を選択</option>
                        <option value="kougaku" <?php if ($user['faculty'] == 'kougaku')
                            echo 'selected'; ?>>工学部</option>
                        <option value="souzou" <?php if ($user['faculty'] == 'souzou')
                            echo 'selected'; ?>>創造工学部</option>
                        <option value="senshin" <?php if ($user['faculty'] == 'senshin')
                            echo 'selected'; ?>>先進工学部
                        </option>
                        <option value="jouhenkaku" <?php if ($user['faculty'] == 'jouhenkaku')
                            echo 'selected'; ?>>情報変革科学部
                        </option>
                        <option value="mirai" <?php if ($user['faculty'] == 'mirai')
                            echo 'selected'; ?>>未来変革科学部</option>
                        <option value="jouhou" <?php if ($user['faculty'] == 'jouhou')
                            echo 'selected'; ?>>情報科学部</option>
                        <option value="shakai" <?php if ($user['faculty'] == 'shakai')
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
                        <option value="department1" <?php if ($user['department'] == 'department1')
                            echo 'selected'; ?>>
                            学科1</option>
                        <option value="department2" <?php if ($user['department'] == 'department2')
                            echo 'selected'; ?>>
                            学科2</option>
                    </select>
                </td>
            </tr>
        </table>

        <!-- 更新ボタン -->
        <input type="submit" name="update" value="更新">
    </form>
</body>

</html>