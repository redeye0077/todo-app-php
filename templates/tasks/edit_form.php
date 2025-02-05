<?php
require_once __DIR__ . '/../../src/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /todo-app-php/templates/login_form.php');
    exit;
}

$task_id = $_GET['task_id'] ?? '';

if (empty($task_id)) {
    die('タスクIDが指定されていません。');
}

// タスクの詳細を取得
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $task_id, ':user_id' => $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task) {
    die('タスクが見つかりません。');
}

// セッションからエラーメッセージを取得
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク編集</title>
</head>
<body>
    <h1>タスク編集</h1>
    <a href="/todo-app-php/templates/tasks/tasks_list.php">タスク一覧に戻る</a>
    <br><br>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/todo-app-php/src/edit_task.php" method="POST" novalidate>
        <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
        <label for="title">タイトル</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br><br>

        <label for="description">説明</label><br>
        <textarea id="description" name="description"><?= htmlspecialchars($task['description']) ?></textarea><br><br>

        <label for="status">ステータス</label><br>
        <select id="status" name="status">
            <option value="incomplete" <?= $task['status'] === 'incomplete' ? 'selected' : '' ?>>未完了</option>
            <option value="complete" <?= $task['status'] === 'complete' ? 'selected' : '' ?>>完了</option>
        </select><br><br>

        <button type="submit">更新</button>
    </form>
</body>
</html>