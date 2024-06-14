<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "ユーザが見つかりません。";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $department = $user['department'];

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id, department) VALUES (:title, :content, :user_id, :department)");
        $stmt->execute(['title' => $title, 'content' => $content, 'user_id' => $user_id, 'department' => $department]);
    }
}

$allPostsStmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
$allPosts = $allPostsStmt->fetchAll(PDO::FETCH_ASSOC);

$title = "全体掲示板";
$heading = "全体掲示板";
require 'header.php';
?>

<form method="POST" action="">
    <input type="text" name="title" placeholder="タイトル" required>
    <textarea name="content" placeholder="内容" required></textarea>
    <button type="submit">投稿</button>
</form>

<h2>投稿一覧</h2>
<?php foreach ($allPosts as $post): ?>
    <div>
        <h3><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')); ?></p>
        <small><?php echo htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?> -
            <?php echo $post['created_at']; ?></small>
    </div>
    <hr>
<?php endforeach; ?>

<?php require 'footer.php'; ?>