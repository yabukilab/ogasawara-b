<?php
    session_Start();
    $userid = $_SESSION['user_id'];             //登録されているユーザID
    $username = $_SESSION['user_name'];         //登録されているユーザ名
    $department = $_SESSION['department_name']; //登録されている学科名
    $selected = $_SESSION['selected'];          //選択された学科（全体の時はzen）
    $chat = $_POST['chat'];                     //つぶやきコメント

    $_SESSION['user_id'] = $userid;
    $_SESSION['user_name'] = $username;
    $_SESSION['department_name'] = $department;

    // echo "ユーザID： $userid</br>";
    // echo "ユーザ名； $username</br>";
    // echo "学科略語：$department</br>";
  
    // 全体投稿を選択された時は学科略語をzenとする
    if ($selected == "zen") {
        $department = "zen";
    }

    require 'db.php';
    $sql= 'insert into posts (user_id, content, department_id) values (:userid, :chat, :department) ';

    $prepare = $db->prepare($sql);                                   # 準備
    $prepare->bindValue(':userid', $userid, PDO::PARAM_STR);         # 埋め込み1
    $prepare->bindValue(':chat', $chat, PDO::PARAM_STR);             # 埋め込み2
    $prepare->bindValue(':department', $department, PDO::PARAM_STR); # 埋め込み3
    $prepare->execute();                                             # 実行

    $url = "./dept_board.php?dept=" . $department;
    header("Location:" . $url);
    exit();
?>