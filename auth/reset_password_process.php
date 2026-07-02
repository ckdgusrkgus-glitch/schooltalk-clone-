<?php
// auth/reset_password_process.php
require '../config/db.php';

$login_id             = trim($_POST['login_id'] ?? '');
$name                 = trim($_POST['name'] ?? '');
$new_password         = $_POST['new_password'] ?? '';
$new_password_confirm = $_POST['new_password_confirm'] ?? '';

if ($login_id === '' || $name === '' || $new_password === '') {
    echo "<script>alert('모든 항목을 입력해주세요.'); history.back();</script>";
    exit;
}

if ($new_password !== $new_password_confirm) {
    echo "<script>alert('새 비밀번호가 일치하지 않습니다.'); history.back();</script>";
    exit;
}

// 아이디 + 이름이 동시에 일치하는 계정 찾기
$stmt = $pdo->prepare("SELECT * FROM users WHERE login_id = :login_id AND name = :name");
$stmt->execute(['login_id' => $login_id, 'name' => $name]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<script>alert('일치하는 계정 정보를 찾을 수 없습니다.'); history.back();</script>";
    exit;
}

// 본인 확인 통과 → 비밀번호 변경
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$update = $pdo->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
$update->execute([
    'password' => $hashed_password,
    'user_id'  => $user['user_id']
]);

echo "<script>alert('비밀번호가 재설정되었습니다. 로그인해주세요.'); location.href='login.php';</script>";
exit;