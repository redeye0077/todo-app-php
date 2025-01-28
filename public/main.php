<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成功</title>
</head>
<body>
    <h1>ログイン成功</h1>
    <?php
    session_start();
    if (isset($_SESSION['success_message'])) {
        echo '<p>' . htmlspecialchars($_SESSION['success_message']) . '</p>';
        unset($_SESSION['success_message']);
    }
    ?>
    <form action="/todo-app-php/templates/tasks/add_form.php" method="GET">
        <button type="submit">タスク追加画面に移動</button>
    </form>
    <form action="/todo-app-php/templates/tasks/tasks_list.php" method="GET">
        <button type="submit">タスク一覧画面に移動</button>
    </form>
    <form action="/todo-app-php/src/logout.php" method="POST">
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>