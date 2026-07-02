<?php
// auth/login_process.php
session_start();
require '../config/db.php';

$login_id = $_POST['login_id'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE login_id = :login_id");
$stmt->execute(['login_id' => $login_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role']    = $user['role'];
    $_SESSION['name']    = $user['name'];
    header('Location: ../index.php');
    exit;
} else {
    echo "<script>alert('아이디 또는 비밀번호가 올바르지 않습니다.'); history.back();</script>";
}