<?php

// セッションの有効期限を設定
ini_set('session.gc_maxlifetime', 3600); // 1時間
session_set_cookie_params(3600);

session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/validation.php';

$errors = [];
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ログイン成功
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: /todo-app-php/public/main.php');
        exit;
    } else {
        $errors = validateLoginInput($pdo, $email, $password);
    }
    include '../templates/login_form.php';
} 
?> 