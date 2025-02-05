<?php
require_once __DIR__ . '/../../src/db.php';

session_start();

// ログインしていない場合はリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: /todo-app-php/public/login_form.php');
    exit;
}

// タスクを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('データベースエラー: ' . $e->getMessage());
    die('タスクの取得中に問題が発生しました。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク一覧</title>
    <link rel="stylesheet" href="/todo-app-php/public/assets/tasks_list.css">
</head>
<body>
    <h1>タスク一覧</h1>
    <a href="/todo-app-php/templates/tasks/add_form.php">タスクを追加</a>
    <a href="/todo-app-php/public/main.php">メイン画面に戻る</a>
    <br><br>

    <?php if (count($tasks) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>タスク名</th>
                    <th>詳細</th>
                    <th>ステータス</th>
                    <th>作成日時</th>
                    <th>編集</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description']) ?></td>
                        <td><?= $task['status'] === 'complete' ? '完了' : '未完了' ?></td>
                        <td><?= htmlspecialchars($task['created_at']) ?></td>
                        <td><a href="/todo-app-php/templates/tasks/edit_form.php?task_id=<?= $task['id'] ?>">編集</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>タスクがありません。</p>
    <?php endif; ?>
</body>
</html>
