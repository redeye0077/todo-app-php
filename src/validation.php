<?php

function validateUserInput($pdo, $username, $email, $password) {
    $errors = [];

    // ユーザー名のチェック
    if (empty($username)) {
        $errors[] = 'ユーザー名を入力してください。';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = 'ユーザー名は3〜50文字で入力してください。';
    }

    // メールアドレスのチェック
    if (empty($email)) {
        $errors[] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = '有効なメールアドレスを入力してください。';
    }

    // パスワードのチェック
    if (empty($password)) {
        $errors[] = 'パスワードを入力してください。';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = 'パスワードは8文字以上で、英数字を含む必要があります。';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'このメールアドレスは既に登録されています。';
    }

    return $errors;
}
