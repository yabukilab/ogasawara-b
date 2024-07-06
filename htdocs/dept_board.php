<?php
session_start();
require 'db2.php';

// 登録した学科を取得
$department = isset($_GET['dept']) ? $_GET['dept'] : '';

if (empty($department)) {
    echo "<div style='color: red;'>学科が選択されていません。</div>";
    exit();
}

// 学科名を取得する
$departments = [
    'ut' => '宇宙・半導体工学科',
    'sen' => '先端材料工学科',
    'den' => '電気電子工学科',
    'jo' => '情報通信システム工学科',
    'ouyo' => '応用化学科',
    'ken' => '建築学科',
    'tosi' => '都市環境工学科',
    'deza' => 'デザイン科学科',
    'seimei' => '生命科学科',
    'tinome' => '知能メディア学科',
    'jouhou' => '情報工学科',
    'ninti' => '認知情報科学科',
    'koudo' => '高度応用情報科学科',
    'dejihen' => 'デジタル変革科学科',
    'keideza' => '経営デザイン科学科',
    'net' => '情報ネットワーク学科',
    'keijou' => '経営情報科学科',
    'pm' => 'プロジェクトマネジメント学科',
    'kinyuu' => '金融・経営リスク科学科'
];

$department_name = $departments[$department] ?? '';

if (empty($department_name)) {
    echo "<div style='color: red;'>無効な学科が選択されています。</div>";
    exit();
}

// 掲示板データを取得
$sql = 'SELECT * FROM boards WHERE department = :department ORDER BY date DESC';
$stmt = $db->prepare($sql);
$stmt->bindParam(':department', $department, PDO::PARAM_STR);
$stmt->execute();
$boards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<<<<<<< HEAD
    <head>
        <meta charset="UTF-8">
        <title>全体掲示板</title>
        <link rel="stylesheet" href="st4.css">
    </head>

    <?php
    session_start();
    $selected = $_GET['dept'];                  //選択した学科（全体掲示板の時はzen）
    $userid = $_SESSION['user_id'];             //登録されているユーザID
    $username = $_SESSION['user_name'];         //登録されているユーザ名
    $department = $_SESSION['department_name']; //登録されている学科名
    
    // echo "ユーザID；{$userid}</br>";
    // echo "ユーザ名：{$username}</br>";
    // echo "学科ID：{$department}</br>";
    
    $_SESSION['user_id'] = $userid;
    $_SESSION['user_name'] = $username;
    $_SESSION['department_name'] = $department;
    $_SESSION['selected'] = $selected;

    // 登録されているchatをDBから読み込み表示する
    require 'db.php';                               # 接続

    if ($selected == "zen") {
        // 全体掲示板に登録されているメッセージを表示
        $sql = 'SELECT * FROM posts where department_id = "zen"'; # SQL文
        $prepare = $db->prepare($sql);                            # 準備
        $prepare->execute();                                      # 実行
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);           # 結果の取得
        foreach ($result as $row) {
            $id = h($row['user_id']);
            // ユーザ名の取得
            $sql = 'SELECT username FROM users where id = '. $id; # SQL文
            $prepare = $db->prepare($sql);                        # 準備
            $prepare->execute();                                  # 実行
            $result2 = $prepare->fetch(PDO::FETCH_ASSOC);         # 結果の取得
            $name = h($result2['username']);

            // 学科名の取得
            $sql = 'SELECT gakka FROM department where ryakugo ='.'"'.$department.'"'; # SQL文
            $prepare = $db->prepare($sql);                                              # 準備
            $prepare->execute();                                                        # 実行
            $result3 = $prepare->fetch(PDO::FETCH_ASSOC);                               # 結果の取得
            $gakka = h($result3['gakka']);

            // 日付とチャットコメントの取得
            $date = h($row['created_at']);
            $chat = h($row['content']);

            // 登録されているチャットコメントの表示
            echo "投稿日：$date</br>";
            echo "名前：$name</br>";
            echo "学科：$gakka</br>";
            echo "コメント：$chat</br></br>";
        }
    } else {
        if ($selected == $department) {
            // 学科が一致した場合

            // 学科名の取得
            $sql = 'SELECT gakka FROM department where ryakugo ='.'"'.$department.'"'; # SQL文
            $prepare = $db->prepare($sql);                                              # 準備
            $prepare->execute();                                                        # 実行
            $result3 = $prepare->fetch(PDO::FETCH_ASSOC);                               # 結果の取得
            $gakka = h($result3['gakka']);
            
            // チャットコメントの表示
            $sql = 'SELECT * FROM posts where department_id ='.'"'.$department.'"'; # SQL文
            $prepare = $db->prepare($sql);                                          # 準備
            $prepare->execute();                                                    # 実行
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);                         # 結果の取得
            foreach ($result as $row) {
                $id = h($row['user_id']);
                // ユーザ名の取得
                $sql = 'SELECT username FROM users where id = '. $id; # SQL文
                $prepare = $db->prepare($sql);                        # 準備
                $prepare->execute();                                  # 実行
                $result2 = $prepare->fetch(PDO::FETCH_ASSOC);         # 結果の取得
                $name = h($result2['username']);

                // 日付とチャットコメントの取得
                $date = h($row['created_at']);
                $chat = h($row['content']);

                // 登録されているチャットコメントの表示
                echo "投稿日：$date</br>";
                echo "名前：$name</br>";
                echo "学科：$gakka</br>";
                echo "コメント：$chat</br></br>";
            }
        } else {
            // 選択した学科と登録された学科が一致しない
            // この画面にとどまる（エラーメッセージを出した方がよい）
            header('Location: ./menu.php');
        }
    }
    ?>
    
    <!-- メッセージの登録処理 -->
    <form method="POST" action="savechat.php">
        <textarea name="chat" rows="6" cols="60">自由に書き込んでください</textarea></br>
        <input type="submit" valut="登録" />
        <input type="reset" value="取り消し" />
        <a href="./menu.php">掲示板画面に戻る</a>
    </form>
=======
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($department_name); ?>の掲示板</title>
    <link rel="stylesheet" href="st4.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($department_name); ?>の掲示板</h1>
    <div class="board-container">
        <?php if (count($boards) > 0): ?>
            <?php foreach ($boards as $index => $board): ?>
                <div class="board-post">
                    <h2><?php echo htmlspecialchars($index + 1) . '. ' . htmlspecialchars($board['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($board['content'])); ?></p>
                    <span>投稿者: <?php echo htmlspecialchars($board['author']); ?></span>
                    <span>投稿日: <?php echo htmlspecialchars($board['date']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>掲示板にはまだ投稿がありません。</p>
        <?php endif; ?>
    </div>
</body>
>>>>>>> 303895bfbe29f6693cba112007e7a403bd33a736
</html>
