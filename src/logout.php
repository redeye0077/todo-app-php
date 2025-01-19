<?php
session_start();

// セッションを破棄
session_unset();
session_destroy();

// ログインページにリダイレクト
header('Location: /todo-app-php/templates/login_form.php');
exit;
?>
