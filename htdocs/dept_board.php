<?php
require 'db.php';
session_start();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ユーザー情報を取得
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "ユーザが見つかりません。";
    exit;
}

// 投稿の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $department = $user['department'];

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO sabposts (title, content, user_id, department) VALUES (:title, :content, :user_id, :department)");
        $stmt->execute(['title' => $title, 'content' => $content, 'user_id' => $user_id, 'department' => $department]);
    }
}

// ユーザーの学科の投稿を取得
$deptPostsStmt = $pdo->prepare("SELECT sabposts.*, users.username FROM sabposts JOIN users ON sabposts.user_id = users.id WHERE sabposts.department = :department ORDER BY sabposts.created_at DESC");
$deptPostsStmt->execute(['department' => $user['department']]);
$deptPosts = $deptPostsStmt->fetchAll(PDO::FETCH_ASSOC);

// ページタイトルとヘディングを設定
$title = htmlspecialchars($user['department'], ENT_QUOTES, 'UTF-8') . "学科掲示板";
$heading = htmlspecialchars($user['department'], ENT_QUOTES, 'UTF-8') . "学科掲示板";
require 'header.php';
?>

<form method="POST" action="">
    <input type="text" name="title" placeholder="タイトル" required>
    <textarea name="content" placeholder="内容" required></textarea>
    <button type="submit">投稿</button>
</form>

<h2>投稿一覧</h2>
<?php foreach ($deptPosts as $post): ?>
    <div>
        <h3><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')); ?></p>
        <small><?php echo htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?> -
            <?php echo $post['created_at']; ?></small>
    </div>
    <hr>
<?php endforeach; ?>

<?php require 'footer.php'; ?>