<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>掲示板一覧</title>
    <style>
        body {
            background-color: #d7e7f6;
        }

        /* <h1>をセンターに配置 */
        h1 {
            color: red;
            text-align: center;
        }

        /* ユーザー情報のスタイル */
        .user-info {
            text-align: center;
            margin-bottom: 20px;
        }

        /* ボタンの基本スタイル */
        .button {
            display: inline-flex;
            padding: 10px 30px;
            margin: 10px 5px;
            width: 425px; /* 統一された幅 */
            height: 50px; /* 統一された高さ */
            font-size: 30px;
            color: white;
            background-color: #070707;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            justify-content: center; /* 中央揃え */
            align-items: center; /* 中央揃え */
        }

        /* ボタンホバー時のスタイル */
        .button:hover {
            background-color: #bebebe;
        }

        /* ボタンをブロック要素として扱い、中央揃えにする */
        .button-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>掲示板画面</h1>

    <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit();
        }
        $userid = $_SESSION['user_id'];
        $username = $_SESSION['user_name'];
        $department_id = $_SESSION['department_name'];
    
        $_SESSION['user_id'] = $userid;
        $_SESSION['user_name'] = $username;
        $_SESSION['department_name'] = $department_id;
    
        require 'db.php';
        // 学科名の取得
        $sql = 'SELECT gakka FROM department where ryakugo ='.'"'.$department_id.'"'; # SQL文
        $prepare = $db->prepare($sql);                                              # 準備
        $prepare->execute();                                                        # 実行
        $result = $prepare->fetch(PDO::FETCH_ASSOC);                               # 結果の取得
        $gakka = h($result['gakka']);
    ?>

    <div class="user-info">
        <!--<p>ユーザーID: <?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?></p>-->
        <p>ユーザ名: <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>学科名: <?php echo htmlspecialchars($gakka, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
<?php
if(isset($_GET['error'])&&$_GET['error']=='mati'):?>
<div style="color : red; text-align:center; font-weight:bold;">学科が間違っています</div>
<?php endif;?>
    <div class="button-container">
        <a class="button" href="list.php?dept=zen">全体掲示板</a><br>
        <a class="button" href="list.php?dept=ut">宇宙・半導体工学科</a><br>
        <a class="button" href="list.php?dept=sen">先端材料工学科</a><br>
        <a class="button" href="list.php?dept=den">電気電子工学科</a><br>
        <a class="button" href="list.php?dept=jo">情報通信システム工学科</a><br>
        <a class="button" href="list.php?dept=ouyo">応用化学科</a><br>
        <a class="button" href="list.php?dept=ken">建築学科</a><br>
        <a class="button" href="list.php?dept=tosi">都市環境工学科</a><br>
        <a class="button" href="list.php?dept=deza">デザイン科学科</a><br>
        <a class="button" href="list.php?dept=seimei">生命科学科</a><br>
        <a class="button" href="list.php?dept=tinome">知能メディア学科</a><br>
        <a class="button" href="list.php?dept=jouhou">情報工学科</a><br>
        <a class="button" href="list.php?dept=ninti">認知情報科学科</a><br>
        <a class="button" href="list.php?dept=koudo">高度応用情報科学科</a><br>
        <a class="button" href="list.php?dept=dejihen">デジタル変革科学科</a><br>
        <a class="button" href="list.php?dept=keideza">経営デザイン科学科</a><br>
        <a class="button" href="list.php?dept=net">情報ネットワーク学科</a><br>
        <a class="button" href="list.php?dept=keijou">経営情報科学科</a><br>
        <a class="button" href="list.php?dept=pm">プロジェクトマネジメント学科</a><br>
        <a class="button" href="list.php?dept=kinyuu">金融・経営リスク科学科</a><br>
    </div>
</body>
</html>
