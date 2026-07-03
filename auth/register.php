<?php
// auth/register.php
session_start();
if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8"><title>회원가입 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h2>회원가입</h2>

        <form action="register_process.php" method="post">
            <label>계정</label>
            <input type="text" name="login_id" placeholder="아이디를 입력해 주세요" required>

            <label>비밀번호</label>
            <input type="password" name="password" placeholder="비밀번호를 입력해 주세요" required minlength="4">

            <label>비밀번호 확인</label>
            <input type="password" name="password_confirm" placeholder="비밀번호를 입력해 주세요" required minlength="4">

            <label>이름</label>
            <input type="text" name="name" placeholder="이름을 입력해 주세요" required>

            <div class="radio-group">
                <label style="display:flex;align-items:center;gap:6px;font-weight:normal;">
                    <input type="radio" name="role" value="teacher" checked style="width:auto;margin:0;"> 교사
                </label>
                <label style="display:flex;align-items:center;gap:6px;font-weight:normal;">
                    <input type="radio" name="role" value="parent" style="width:auto;margin:0;"> 학부모
                </label>
            </div>

            <button type="submit" class="btn btn-block">가입하기</button>
        </form>

        <div class="auth-links">이미 계정이 있으신가요? <a href="login.php">로그인</a></div>
    </div>
</body>
</html>