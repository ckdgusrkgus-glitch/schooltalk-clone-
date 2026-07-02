<?php
// auth/find_password.php
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
    <title>비밀번호 재설정 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>비밀번호 재설정</h2>

    <form action="reset_password_process.php" method="post">
        <label>아이디</label>
        <input type="text" name="login_id" required>

        <label>이름</label>
        <input type="text" name="name" required>

        <label>새 비밀번호</label>
        <input type="password" name="new_password" required minlength="4">

        <label>새 비밀번호 확인</label>
        <input type="password" name="new_password_confirm" required minlength="4">

        <button type="submit">재설정</button>
    </form>

    <a href="login.php">로그인으로 돌아가기</a>
</body>
</html>