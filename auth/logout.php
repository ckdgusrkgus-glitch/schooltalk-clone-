<?php
// auth/logout.php
session_start();
session_destroy();   // 세션 데이터 전체 파기
header('Location: login.php');
exit;