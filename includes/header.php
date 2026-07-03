<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>스쿨톡</title>
    <link rel="stylesheet" href="/schooltalk/assets/css/style.css">
</head>
<body>
<header>
    <div class="header-inner">
        <a href="/schooltalk/index.php" class="logo">
           <img src="/schooltalk/assets/images/logo.png" alt="넷브리즈 로고"
                style="height:36px; width:auto; object-fit:contain;">
            <span>
                <span class="school-name" style="display:block">넷브리즈 고등학교</span>
                <span class="service-name">스쿨톡</span>
            </span>
        </a>

        <nav>
            <a href="/schooltalk/notice/list.php"
               class="<?= ($active_menu ?? '') === 'notice' ? 'active' : '' ?>">공지사항</a>

            <?php if ($_SESSION['role'] === 'teacher'): ?>
                <a href="/schooltalk/attendance/list.php"
                   class="<?= ($active_menu ?? '') === 'attendance' ? 'active' : '' ?>">출결 관리</a>
                <a href="/schooltalk/visitor/list.php"
                   class="<?= ($active_menu ?? '') === 'visitor' ? 'active' : '' ?>">방문 예약 관리</a>
            <?php else: ?>
                <a href="/schooltalk/student/list.php"
                   class="<?= ($active_menu ?? '') === 'student' ? 'active' : '' ?>">자녀등록</a>
                <a href="/schooltalk/attendance/view.php"
                   class="<?= ($active_menu ?? '') === 'attendance' ? 'active' : '' ?>">자녀 출결 조회</a>
                <a href="/schooltalk/visitor/apply.php"
                   class="<?= ($active_menu ?? '') === 'visitor' ? 'active' : '' ?>">방문 예약 신청</a>
            <?php endif; ?>
        </nav>

        <div class="user-area">
            <span><?= htmlspecialchars($_SESSION['name']) ?>님</span>
            <a href="/schooltalk/auth/logout.php">로그아웃</a>
        </div>
    </div>
</header>
<main>