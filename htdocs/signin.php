<?php
require 'db.php2'; // データベース接続情報を含むファイルをインクルード

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';
    $faculty = $_POST["faculty"] ?? '';
    $department = $_POST["department"] ?? '';

    // データの検証（空でないかチェック）
    if ($user && $pass && $faculty && $department) {
        // パスワードをハッシュ化
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // ユーザ名の重複チェック
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "エラー: ユーザ名が既に存在します。";
        } else {
            // SQLインジェクションを防ぐためにプリペアドステートメントを使用
            $stmt = $db->prepare("INSERT INTO users (username, password, faculty, department) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$user, $hashed_pass, $faculty, $department])) {
                // 登録が完了したらリダイレクト
                header("Location: ./index.php");
                exit();
            } else {
                echo "エラー: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo "全てのフィールドを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>新規登録</title>
    <link rel="stylesheet" href="st2.css">
</head>

<body>
    <h1>新規登録</h1>
    <form action="" method="POST">
        <!-- User registration fields -->
        <table>
            <tr>
                <td><label for="username">ユーザ名</label></td>
                <td><input type="text" name="username" id="username" required></td>
            </tr>
            <tr>
                <td><label for="password">パスワード</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="faculty">学部</label></td>
                <td>
                    <select class="mainselect" name="faculty" id="faculty" required>
                        <option value="">学部を選択</option>
                        <option value="kougaku">工学部</option>
                        <option value="souzou">創造工学部</option>
                        <option value="senshin">先進工学部</option>
                        <option value="jouhenkaku">情報変革科学部</option>
                        <option value="mirai">未来変革科学部</option>
                        <option value="jouhou">情報科学部</option>
                        <option value="shakai">社会システム科学部</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="department">学科</label></td>
                <td>
                    <select name="department" id="department" class="subbox" required>
                        <option value="">学科を選択</option>
                    </select>
                </td>
            </tr>
        </table>

        <!-- 新規登録 button -->
        <input type="submit" name="signin" value="新規登録">
    </form>

    <script>
        // 学部が変更された時の処理
        document.getElementById('faculty').addEventListener('change', function () {
            var selectedFaculty = this.value;
            var departmentSelect = document.getElementById('department');

            // 学科の選択肢を変更する
            var options = '';
            switch (selectedFaculty) {
                case 'kougaku':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='ut'>宇宙・半導体工学科</option>
                        <option value='sen'>先端材料工学科</option>
                        <option value='den'>電気電子工学科</option>
                        <option value='jo'>情報通信システム工学科</option>
                        <option value='ouyo'>応用化学科</option>`;
                    break;
                case 'souzou':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='ken'>建築学科</option>
                        <option value='tosi'>都市環境工学科</option>
                        <option value='deza'>デザイン科学科</option>`;
                    break;
                case 'senshin':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='mirobo'>デザイン科学科</option>
                        <option value='seimei'>生命科学科</option>
                        <option value='tinome'>知能メディア学科</option>`;
                    break;
                case 'jouhenkaku':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='jouhou'>情報工学科</option>
                        <option value='ninti'>認知情報科学科</option>
                        <option value='koudo'>高度応用情報科学科</option>`;
                    break;
                case 'mirai':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='dejihen'>デジタル変革科学科</option>
                        <option value='keideza'>経営デザイン科学科</option>`;
                    break;
                case 'jouhou':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='jouhoukou'>情報工学科</option>
                        <option value='net'>情報ネットワーク学科</option>`;
                    break;
                case 'shakai':
                    options = `
                        <option value=''>学科を選択</option>
                        <option value='keijou'>経営情報科学科</option>
                        <option value='pm'>プロジェクトマネジメント学科</option>
                        <option value='kinyuu'>金融・経営リスク科学科</option>`;
                    break;
                default:
                    options = `<option value=''>学科を選択</option>`;
            }
            departmentSelect.innerHTML = options;
        });
    </script>
</body>

</html>