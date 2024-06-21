<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $user = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';
    $gakubu = $_POST["gakubu"] ?? '';
    $gakka = $_POST["gakka"] ?? '';

    // データの検証（空でないかチェック）
    if ($user && $pass && $gakubu && $gakka) {
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
            $stmt = $db->prepare("INSERT INTO users (username, password, gakubu, gakka) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$user, $hashed_pass, $gakubu, $gakka])) {
                echo "新規登録が完了しました。";
                // 登録が完了したらリダイレクト
                header("Location: http://localhost/keijiban/ogasawara-b/htdocs/index.php");
                exit();
            } else {
                echo "エラー: " . h($stmt->errorInfo()[2]);
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
    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <h1>新規登録</h1>
    <form action="" method="POST">
        <!-- User registration fields -->
        <label for="username">ユーザ名</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password" required><br>
        <label for="gakubu">学部</label>
        <select class='mainselect' name="gakubu" id="gakubu" required>
            <option value="">学部を選択</option>
            <option value='kougaku'>工学部</option>
            <option value='souzou'>創造工学部</option>
            <option value='senshin'>先進工学部</option>
            <option value='jouhenkaku'>情報変革科学部</option>
            <option value='mirai'>未来変革科学部</option>
            <option value='jouhou'>情報科学部</option>
            <option value='shakai'>社会システム科学部</option>
        </select><br>

        <!-- 学科のセレクトボックス -->
        <div id="subbox-container">
            <label for="gakka">学科</label>
            <select name="gakka" id='gakka' class="subbox" required>
                <option value=''>学科を選択</option>
            </select>
        </div>

        <!-- 新規登録 button -->
        <input type="submit" name="signin" value="新規登録">
    </form>

    <script>
        // 学部が変更された時の処理
        document.getElementById('gakubu').addEventListener('change', function () {
            var selectedGakubu = this.value;
            var subboxContainer = document.getElementById('subbox-container');
            var gakkaSelect = document.getElementById('gakka');

            // 学科の選択肢を変更する
            switch (selectedGakubu) {
                case 'kougaku':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='ut'>宇宙・半導体工学科</option>
                        <option value='sen'>先端材料工学科</option>
                        <option value='den'>電気電子工学科</option>
                        <option value='jo'>情報通信システム工学科</option>
                        <option value='ouyo'>応用化学科</option>
                    `;
                    break;
                case 'souzou':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='ken'>建築学科</option>
                        <option value='tosi'>都市環境工学科</option>
                        <option value='deza'>デザイン科学科</option>
                    `;
                    break;
                case 'senshin':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='mirobo'>デザイン科学科</option>
                        <option value='seimei'>生命科学科</option>
                        <option value='tinome'>知能メディア学科</option>
                    `;
                    break;
                case 'jouhenkaku':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='jouhou'>情報工学科</option>
                        <option value='ninti'>認知情報科学</option>
                        <option value='koudo'>高度応用情報科学科</option>
                    `;
                    break;
                case 'mirai':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='dejihen'>デジタル変革科学科</option>
                        <option value='keideza'>経営デザイン科学科</option>
                    `;
                    break;
                case 'jouhou':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='jouhoukou'>情報工学科</option>
                        <option value='net'>情報ネットワーク学科</option>
                    `;
                    break;
                case 'shakai':
                    gakkaSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='keijou'>経営情報科学科</option>
                        <option value='pm'>プロジェクトマネジメント学科</option>
                        <option value='kinyuu'>金融・経営リスク科学科</option>
                    `;
                    break;
                default:
                    gakkaSelect.innerHTML = `<option value=''>学科を選択</option>`;
            }
        });
    </script>
</body>

</html>