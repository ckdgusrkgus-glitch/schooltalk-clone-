<?php
// auth/find_password.php
session_start();
if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8"><title>비밀번호 재설정 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h2>비밀번호 재설정</h2>

        <form action="reset_password_process.php" method="post">
            <label>계정</label>
            <input type="text" name="login_id" placeholder="아이디를 입력해 주세요" required>

            <label>이름</label>
            <input type="text" name="name" placeholder="이름을 입력해 주세요" required>

            <label>새 비밀번호</label>
            <input type="password" name="new_password" placeholder="비밀번호를 입력해 주세요" required minlength="4">

            <label>새 비밀번호 확인</label>
            <input type="password" name="new_password_confirm" placeholder="비밀번호를 입력해 주세요" required minlength="4">

            <button type="submit" class="btn btn-block">재설정</button>
        </form>

        <div class="auth-links"><a href="login.php">로그인으로 돌아가기</a></div>
    </div>
</body>
</html>