<?php
require_once __DIR__ . '/../vendor/autoload.php';

// .env ファイルを読み込む
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// .env の値を取得
$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    // PDO接続
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log("データベース接続成功！");
} catch (PDOException $e) {
    error_log("データベース接続に失敗しました: " . $e->getMessage());
    die("データベース接続に失敗しました。");
}
?>
