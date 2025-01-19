<?php
require_once __DIR__ . '/../src/init.php';
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="/todo-app-php/public/assets/register.css">
</head>
<body>
    <h1>ユーザー登録</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/todo-app-php/src/register.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <label for="username">名前</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">メール</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirm">パスワード確認</label><br>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>

        <button type="submit">登録</button>
    </form>
</body>
</html>
