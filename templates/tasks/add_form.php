<?php
session_start();

// ログインしていない場合にリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: /todo-app-php/templates/login_form.php');
    exit;
}

if (!empty($_SESSION['errors'])) {
    echo '<ul>';
    foreach ($_SESSION['errors'] as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }
    echo '</ul>';
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
    <link rel="stylesheet" href="/todo-app-php/public/assets/add_form.css">
</head>
<body>
    <h1>タスク追加</h1>
    <form action="/todo-app-php/src/add_task.php" method="POST" novalidate>
        <label for="title">タイトル</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">説明</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="status">ステータス</label><br>
        <select id="status" name="status">
            <option value="incomplete">未完了</option>
            <option value="complete">完了</option>
        </select><br><br>

        <button type="submit">追加</button>
        <a href="/todo-app-php/templates/tasks/tasks_list.php">タスク一覧画面に移動</a>
    </form>
</body>
</html>
