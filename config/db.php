<?php
// config/db.php
$host = '127.0.0.1';
$dbname = 'schooltalk_clone';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('DB 연결 실패: ' . $e->getMessage());
}
