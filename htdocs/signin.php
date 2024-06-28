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
        <label for="username">ユーザ名</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password" required><br>
        <label for="faculty">学部</label>
        <select class='mainselect' name="faculty" id="faculty" required>
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
            <label for="department">学科</label>
            <select name="department" id='department' class="subbox" required>
                <option value=''>学科を選択</option>
            </select>
        </div>

        <!-- 新規登録 button -->
        <input type="submit" name="signin" value="新規登録">
    </form>

    <script>
        // 学部が変更された時の処理
        document.getElementById('faculty').addEventListener('change', function () {
            var selectedFaculty = this.value;
            var subboxContainer = document.getElementById('subbox-container');
            var departmentSelect = document.getElementById('department');

            // 学科の選択肢を変更する
            switch (selectedFaculty) {
                case 'kougaku':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='ut'>宇宙・半導体工学科</option>
                        <option value='sen'>先端材料工学科</option>
                        <option value='den'>電気電子工学科</option>
                        <option value='jo'>情報通信システム工学科</option>
                        <option value='ouyo'>応用化学科</option>
                    `;
                    break;
                case 'souzou':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='ken'>建築学科</option>
                        <option value='tosi'>都市環境工学科</option>
                        <option value='deza'>デザイン科学科</option>
                    `;
                    break;
                case 'senshin':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='mirobo'>デザイン科学科</option>
                        <option value='seimei'>生命科学科</option>
                        <option value='tinome'>知能メディア学科</option>
                    `;
                    break;
                case 'jouhenkaku':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='jouhou'>情報工学科</option>
                        <option value='ninti'>認知情報科学科</option>
                        <option value='koudo'>高度応用情報科学科</option>
                    `;
                    break;
                case 'mirai':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='dejihen'>デジタル変革科学科</option>
                        <option value='keideza'>経営デザイン科学科</option>
                    `;
                    break;
                case 'jouhou':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='jouhoukou'>情報工学科</option>
                        <option value='net'>情報ネットワーク学科</option>
                    `;
                    break;
                case 'shakai':
                    departmentSelect.innerHTML = `
                        <option value=''>学科を選択</option>
                        <option value='keijou'>経営情報科学科</option>
                        <option value='pm'>プロジェクトマネジメント学科</option>
                        <option value='kinyuu'>金融・経営リスク科学科</option>
                    `;
                    break;
                default:
                    departmentSelect.innerHTML = `<option value=''>学科を選択</option>`;
            }
        });
    </script>
</body>

</html>