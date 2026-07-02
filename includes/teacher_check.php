<?php
// includes/teacher_check.php
require 'auth_check.php';   // 로그인 여부 먼저 확인

if ($_SESSION['role'] !== 'teacher') {
    die('접근 권한이 없습니다.');
}