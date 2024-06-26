<?php
// データベース接続ファイルをインクルード
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームからの入力値を取得
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードのハッシュ化
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];

    // 新規ユーザーをデータベースに挿入
    $stmt = $db->prepare("INSERT INTO users (username, password, faculty, department) VALUES (:username, :password, :faculty, :department)");
    $stmt->execute(['username' => $username, 'password' => $password, 'faculty' => $faculty, 'department' => $department]);

    echo "ユーザー登録が完了しました。";
}
?>
<?php
// データベース接続ファイルをインクルード
require 'db.php';
// セッションを開始
session_start();

// ログインしているか確認し、していなければログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// セッションからユーザIDを取得
$user_id = $_SESSION['user_id'];

// ユーザ情報を取得するためのSQL準備と実行
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザが見つからなければエラーメッセージを表示して終了
if (!$user) {
    echo "ユーザが見つかりません。";
    exit;
}

// POSTリクエストが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームからの入力値を取得
    $title = $_POST['title'];
    $content = $_POST['content'];
    $faculty = $user['faculty'];
    $department = $user['department'];

    // タイトルと内容が空でないか確認
    if (!empty($title) && !empty($content)) {
        // 新規投稿をデータベースに挿入
        $stmt = $db->prepare("INSERT INTO sabposts (title, content, user_id, faculty, department) VALUES (:title, :content, :user_id, :faculty, :department)");
        $stmt->execute(['title' => $title, 'content' => $content, 'user_id' => $user_id, 'faculty' => $faculty, 'department' => $department]);
    }
}

// 全ての投稿を取得するSQLクエリを実行
$allPostsStmt = $db->query("SELECT sabposts.*, users.username, users.faculty, users.department FROM sabposts JOIN users ON sabposts.user_id = users.id ORDER BY sabposts.created_at DESC");
$allPosts = $allPostsStmt->fetchAll(PDO::FETCH_ASSOC);

// 学部ごとに投稿を分類
$postsByFaculty = [];
foreach ($allPosts as $post) {
    $postsByFaculty[$post['faculty']][] = $post;
}

// ページのタイトルと見出しを設定
$title = "全体掲示板";
$heading = "全体掲示板";

// ヘッダーファイルをインクルード
require 'header.php';
?>

<!-- 投稿フォーム -->
<form method="POST" action="">
    <input type="text" name="title" placeholder="タイトル" required>
    <textarea name="content" placeholder="内容" required></textarea>
    <button type="submit">投稿</button>
</form>

<h2>投稿一覧</h2>
<!-- 学部ごとに投稿を表示 -->
<?php foreach ($postsByFaculty as $faculty => $posts): ?>
    <h3><?php echo htmlspecialchars($faculty, ENT_QUOTES, 'UTF-8'); ?>の投稿</h3>
    <?php foreach ($posts as $post): ?>
        <div>
            <h4><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')); ?></p>
            <small><?php echo htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?> -
                <?php echo htmlspecialchars($post['department'], ENT_QUOTES, 'UTF-8'); ?> -
                <?php echo $post['created_at']; ?></small>
        </div>
        <hr>
    <?php endforeach; ?>
<?php endforeach; ?>

<!-- フッターファイルをインクルード -->
<?php require 'footer.php'; ?>