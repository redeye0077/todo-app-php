<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/validation.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'incomplete';

    // バリデーションを実行
    $errors = validateTaskInput($title, $description, $status);

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, status) VALUES (:user_id, :title, :description, :status)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':title' => $title,
                ':description' => $description,
                ':status' => $status
            ]);
            // 成功時のメッセージをセッションに保存
            $_SESSION['success_message'] = 'タスクが正常に追加されました。';
            header('Location: /todo-app-php/public/main.php');
            exit;
        } catch (PDOException $e) {
            error_log('データベースエラー: ' . $e->getMessage());
            die('タスクの追加中に問題が発生しました。');
        }
    } else {
        // バリデーションエラーをセッションに保存
        $_SESSION['errors'] = $errors;
        header('Location: /todo-app-php/templates/tasks/add_form.php');
        exit;
    }
}
?>