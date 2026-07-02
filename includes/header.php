<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>스쿨톡</title>
    <link rel="stylesheet" href="/schooltalk/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/schooltalk/notice/list.php">공지사항</a>

            <?php if ($_SESSION['role'] === 'teacher'): ?>
                <a href="/schooltalk/attendance/list.php">출결 관리</a>
                <a href="/schooltalk/visitor/list.php">방문 예약 관리</a>
            <?php else: ?>
                <a href="/schooltalk/student/list.php">자녀 등록</a>
                <a href="/schooltalk/attendance/view.php">자녀 출결 조회</a>
                <a href="/schooltalk/visitor/apply.php">방문 예약 신청</a>

            <?php endif; ?>

            <span><?= htmlspecialchars($_SESSION['name']) ?>님</span>
            <a href="/schooltalk/auth/logout.php">로그아웃</a>
        </nav>
    </header>
    <main>