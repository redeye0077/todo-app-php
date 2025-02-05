<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/validation.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'incomplete';

    // バリデーションを実行
    $errors = validateTaskInput($title, $description, $status);

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, status = :status WHERE id = :id AND user_id = :user_id");
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':status' => $status,
                ':id' => $task_id,
                ':user_id' => $_SESSION['user_id']
            ]);
            // 成功時のメッセージをセッションに保存
            $_SESSION['success_message'] = 'タスクが正常に更新されました。';
            header('Location: /todo-app-php/public/main.php');
            exit;
        } catch (PDOException $e) {
            error_log('データベースエラー: ' . $e->getMessage());
            die('タスクの更新中に問題が発生しました。');
        }
    } else {
        // バリデーションエラーをセッションに保存
        $_SESSION['errors'] = $errors;
        header('Location: /todo-app-php/templates/tasks/edit_form.php?task_id=' . $task_id);
        exit;
    }
} else {
    $task_id = $_GET['task_id'] ?? '';
    if (empty($task_id)) {
        die('タスクIDが指定されていません。');
    }
}
?>