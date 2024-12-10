<?php
// register.php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/validation.php';

$errors = [];
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateUserInput($pdo, $username, $email, $password);

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);
            header('Location: /todo-app-php/public/success.html');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'データベースエラーが発生しました: ' . $e->getMessage();
        }
    }
    include '../templates/register_form.php';
}
