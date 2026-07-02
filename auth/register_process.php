<?php
// auth/register_process.php
session_start();
require '../config/db.php';

$login_id         = trim($_POST['login_id'] ?? '');
$password         = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$name             = trim($_POST['name'] ?? '');
$role             = $_POST['role'] ?? '';

// 1. 기본 유효성 검사
if ($login_id === '' || $password === '' || $name === '') {
    echo "<script>alert('모든 항목을 입력해주세요.'); history.back();</script>";
    exit;
}

if ($password !== $password_confirm) {
    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    exit;
}

if (!in_array($role, ['teacher', 'parent'])) {
    echo "<script>alert('잘못된 요청입니다.'); history.back();</script>";
    exit;
}

// 2. 아이디 중복 확인
$check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login_id = :login_id");
$check->execute(['login_id' => $login_id]);

if ($check->fetchColumn() > 0) {
    echo "<script>alert('이미 사용 중인 아이디입니다.'); history.back();</script>";
    exit;
}

// 3. 비밀번호 암호화 후 저장
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (login_id, password, name, role)
    VALUES (:login_id, :password, :name, :role)
");
$stmt->execute([
    'login_id' => $login_id,
    'password' => $hashed_password,
    'name'     => $name,
    'role'     => $role
]);

// 4. 가입 후 바로 로그인 상태로 전환
$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['role']    = $role;
$_SESSION['name']    = $name;

header('Location: ../index.php');
exit;