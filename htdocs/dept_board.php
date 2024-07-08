<!DOCTYPE html>
<html>

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
<<<<<<< HEAD

=======
?>

<!-- メッセージの登録処理 -->
<form method="POST" action="savechat.php">
    <textarea name="chat" rows="6" cols="60"></textarea></br>
    <input type="submit" valut="登録" />
    <input type="reset" value="取り消し" />
    <a href="./menu.php">掲示板画面に戻る</a>
</form>
<?php
>>>>>>> 81fa620766b72008ac505668f6d7b378b3a02dbe
if ($selected == "zen") {
    // 全体掲示板に登録されているメッセージを表示
    $sql = 'SELECT * FROM posts where department_id = "zen"'; # SQL文
    $prepare = $db->prepare($sql);                            # 準備
    $prepare->execute();                                      # 実行
    $result = $prepare->fetchAll(PDO::FETCH_ASSOC);           # 結果の取得
    foreach ($result as $row) {
        $id = h($row['user_id']);
        // ユーザ名の取得
        $sql = 'SELECT username FROM users where id = ' . $id; # SQL文
        $prepare = $db->prepare($sql);                        # 準備
        $prepare->execute();                                  # 実行
        $result2 = $prepare->fetch(PDO::FETCH_ASSOC);         # 結果の取得
        $name = h($result2['username']);

        // 学科名の取得
        $sql = 'SELECT gakka FROM department where ryakugo =' . '"' . $department . '"'; # SQL文
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
        $sql = 'SELECT gakka FROM department where ryakugo =' . '"' . $department . '"'; # SQL文
        $prepare = $db->prepare($sql);                                              # 準備
        $prepare->execute();                                                        # 実行
        $result3 = $prepare->fetch(PDO::FETCH_ASSOC);                               # 結果の取得
        $gakka = h($result3['gakka']);

        // チャットコメントの表示
        $sql = 'SELECT * FROM posts where department_id =' . '"' . $department . '"'; # SQL文
        $prepare = $db->prepare($sql);                                          # 準備
        $prepare->execute();                                                    # 実行
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);                         # 結果の取得
        foreach ($result as $row) {
            $id = h($row['user_id']);
            // ユーザ名の取得
            $sql = 'SELECT username FROM users where id = ' . $id; # SQL文
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

<<<<<<< HEAD
<!-- メッセージの登録処理 -->
<form method="POST" action="savechat.php">
    <textarea name="chat" rows="6" cols="60" placeholder="自由に書き込んでください"></textarea><br>
    <input type="submit" valut="登録" />
    <input type="reset" value="取り消し" />
    <a href="./menu.php">掲示板画面に戻る</a>
</form>
=======
>>>>>>> 81fa620766b72008ac505668f6d7b378b3a02dbe

</html>