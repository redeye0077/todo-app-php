<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="/todo-app-php/public/assets/login.css">
</head>
<body>
    <h1>ログイン</h1>
<?php
// $errorsが未定義の場合、空の配列として初期化
    if (!isset($errors)) {
        $errors = [];
    }
?>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/todo-app-php/src/login.php" method="POST" novalidate>
        <label for="email">メールアドレス</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">ログイン</button>
    </form>
</body>
</html> 