<?php
// attendance/attendance_process.php
require '../includes/teacher_check.php';
require '../config/db.php';

$student_id  = $_POST['student_id'] ?? '';
$status_list = $_POST['status'] ?? [];

if ($student_id === '' || empty($status_list)) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO attendance (student_id, check_date, status)
    VALUES (:student_id, :check_date, :status)
    ON DUPLICATE KEY UPDATE status = :status2
");

foreach ($status_list as $check_date => $status) {
    $stmt->execute([
        'student_id' => $student_id,
        'check_date' => $check_date,
        'status'     => $status,
        'status2'    => $status
    ]);
}

$year_month = $_POST['year_month'] ?? date('Y-m');
header('Location: list.php?student_id=' . urlencode($student_id) . '&ym=' . urlencode($year_month));
exit;