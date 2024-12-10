<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
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
        <label for="username">名前</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">メール</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">登録</button>
    </form>
</body>
</html>
