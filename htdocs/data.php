<?php
require 'db.php';

// Fetch all rows from the table
function fetchAllRows($db)
{
    $stmt = $db->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$rows = fetchAllRows($db);

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle bulk update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['id'] as $index => $id) {
        $update_id = (int) $id;
        $update_username = $_POST['username'][$index];
        $update_faculty = $_POST['faculty'][$index];
        $update_department = $_POST['department'][$index];
        $stmt = $db->prepare("UPDATE users SET username = ?, faculty = ?, department = ? WHERE id = ?");
        $stmt->execute([$update_username, $update_faculty, $update_department, $update_id]);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ管理</title>
</head>

<body>
    <h1>データ一覧</h1>
    <form action="" method="post">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Faculty</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rows as $index => $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><input type="text" name="username[]"
                            value="<?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <td><input type="text" name="faculty[]"
                            value="<?php echo htmlspecialchars($row['faculty'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <td><input type="text" name="department[]"
                            value="<?php echo htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <td>
                        <input type="hidden" name="id[]"
                            value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <a href="?delete_id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"
                            onclick="return confirm('本当に削除しますか？');">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <input type="submit" name="update" value="一括更新">
    </form>
</body>

</html>