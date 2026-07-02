<?php
// index.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

// 로그인 되어 있으면 공지사항 목록을 기본 화면으로
header('Location: notice/list.php');
exit;