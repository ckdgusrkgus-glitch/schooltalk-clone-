<?php
// auth/login.php
session_start();

// 이미 로그인된 상태면 바로 메인으로
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>로그인 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>로그인</h2>
    <form action="login_process.php" method="post">
        <label>아이디</label>
        <input type="text" name="login_id" required>

        <label>비밀번호</label>
        <input type="password" name="password" required>

        <button type="submit">로그인</button>
    </form>

    <a href="register.php">계정이 없으신가요? 회원가입</a>
    <a href="find_password.php">비밀번호를 잊으셨나요?</a>
</body>
</html>