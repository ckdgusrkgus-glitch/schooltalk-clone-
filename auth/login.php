<?php
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
    <title>로그인 - 스쿨톡</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="page-logo">
        <img src="../assets/images/logo.png" alt="넷브리즈 로고">
        <span>
            <span class="school-name">넷브리즈 고등학교</span>
            <span class="service-name">스쿨톡</span>
        </span>
    </div>

    <div class="auth-card">
        <img src="../assets/images/avatar.png" alt="스쿨톡" style="width:64px; height:64px; object-fit:contain; margin-bottom:16px;">
        <h2>스쿨톡</h2>
        <p class="subtitle">우리 학교를 위한 스마트한 선택</p>
        <form action="login_process.php" method="post">
            <label>계정</label>
            <input type="text" name="login_id" placeholder="아이디를 입력해 주세요" required>

            <label>비밀번호</label>
            <input type="password" name="password" placeholder="비밀번호를 입력해 주세요" required>

            <button type="submit" class="btn btn-block">로그인</button>
        </form>

        <div class="auth-links">
            <a href="find_password.php">비밀번호 재설정</a>
            <a href="register.php" style="margin-left: 42px;">회원가입</a>
        </div>
    </div>
</body>
</html>