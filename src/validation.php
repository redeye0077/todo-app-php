<?php

function validateUserInput($pdo, $username, $email, $password, $password_confirm) {
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

    // パスワード確認のチェック
    if ($password !== $password_confirm) {
        $errors[] = 'パスワードと確認用パスワードが一致しません。';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'このメールアドレスは既に登録されています。';
    }

    return $errors;
}

function validateLoginInput($pdo, $email, $password) {
    $errors = [];
    // メールアドレスのチェック
    if (empty($email)) {
        $errors[] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = '有効なメールアドレスを入力してください。';
    }

    // ユーザー情報を取得
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    // パスワードのチェック
    if (empty($password)) {
        $errors[] = 'パスワードを入力してください。';
    }
    if ($user && !password_verify($password, $user['password'])) {
        $errors[] = 'パスワードが一致しません。';
    }
    
    return $errors;
}

function validateTaskInput($title, $description, $status) {
    $errors = [];

    // タイトルのチェック
    if (empty($title)) {
        $errors[] = 'タイトルを入力してください。';
    } elseif (strlen($title) > 255) {
        $errors[] = 'タイトルは255文字以内で入力してください。';
    }

    // 説明のチェック（任意）
    if (empty($description)) {
        $errors[] = '説明文を入力してください。';
    }

    // ステータスのチェック
    if (!in_array($status, ['incomplete', 'complete'])) {
        $errors[] = 'ステータスを選択してください。';
    }

    return $errors;
}
