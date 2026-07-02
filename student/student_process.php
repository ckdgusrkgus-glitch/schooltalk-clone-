<?php
// student/student_process.php
require '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'parent') {
    die('접근 권한이 없습니다.');
}

$action = $_POST['action'] ?? '';

// ── 자녀 등록 ──
if ($action === 'add') {
    $name       = trim($_POST['name'] ?? '');
    $class_name = trim($_POST['class_name'] ?? '');

    if ($name === '' || $class_name === '') {
        echo "<script>alert('모든 항목을 입력해주세요.'); history.back();</script>";
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO students (parent_id, name, class_name)
        VALUES (:parent_id, :name, :class_name)
    ");
    $stmt->execute([
        'parent_id'  => $_SESSION['user_id'],
        'name'       => $name,
        'class_name' => $class_name
    ]);

    header('Location: list.php');
    exit;
}

// ── 자녀 삭제 ──
if ($action === 'delete') {
    $student_id = $_POST['student_id'] ?? '';

    // 본인 자녀가 맞는지 반드시 확인 (다른 학부모의 자녀 삭제 방지)
    $stmt = $pdo->prepare("
        DELETE FROM students
        WHERE student_id = :student_id AND parent_id = :parent_id
    ");
    $stmt->execute([
        'student_id' => $student_id,
        'parent_id'  => $_SESSION['user_id']
    ]);

    header('Location: list.php');
    exit;
}