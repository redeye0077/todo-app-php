<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/validation.php';

$errors = [];
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }
    $errors = validateUserInput($pdo, $username, $email, $password, $password_confirm);

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);
            header('Location: /todo-app-php/public/templates/login_form.php');
            exit;
        } catch (PDOException $e) {
            error_log('データベースエラー: ' . $e->getMessage());
            $errors[] = '登録中に問題が発生しました。後ほど再試行してください。';
        }
    }
    include '../templates/register_form.php';
}
?> 
