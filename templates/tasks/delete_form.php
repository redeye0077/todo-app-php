<?php
require_once __DIR__ . '/../../src/db.php';

session_start();

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header('Location: /todo-app-php/templates/login_form.php');
    exit;
}

// POSTリクエストであることを確認
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('不正なリクエストです。');
}

$task_id = $_POST['task_id'] ?? '';

// タスクIDのバリデーション
if (empty($task_id) || !is_numeric($task_id)) {
    die('不正なタスクIDです。');
}

// 削除対象のタスクが現在のユーザーのものであるか確認
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $task_id, ':user_id' => $_SESSION['user_id']]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die('タスクが見つかりません。');
}

// タスクを削除
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $task_id, ':user_id' => $_SESSION['user_id']]);

// 成功メッセージをセッションに保存
$_SESSION['success_message'] = 'タスクが削除されました。';
header('Location: /todo-app-php/templates/tasks/tasks_list.php');
exit;
