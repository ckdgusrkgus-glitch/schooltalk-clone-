<?php
// auth/register.php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원가입 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>회원가입</h2>
    <form action="register_process.php" method="post">
        <label>아이디</label>
        <input type="text" name="login_id" required>

        <label>비밀번호</label>
        <input type="password" name="password" required minlength="4">

        <label>비밀번호 확인</label>
        <input type="password" name="password_confirm" required minlength="4">

        <label>이름</label>
        <input type="text" name="name" required>

        <label>구분</label>
        <select name="role" required>
            <option value="parent">학부모</option>
            <option value="teacher">교사</option>
        </select>

        <button type="submit">가입하기</button>
    </form>

    <a href="login.php">이미 계정이 있으신가요? 로그인</a>
</body>
</html>