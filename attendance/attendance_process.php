<?php
// attendance/attendance_process.php
require '../includes/teacher_check.php';
require '../config/db.php';

$student_id  = $_POST['student_id'] ?? '';
$status_list = $_POST['status'] ?? [];  // ['2026-07-15' => '지각', ...]

if ($student_id === '' || empty($status_list)) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO attendance (student_id, check_date, status, check_in)
    VALUES (:student_id, :check_date, :status, :check_in)
    ON DUPLICATE KEY UPDATE status = :status2, check_in = :check_in2
");

foreach ($status_list as $check_date => $status) {
    $check_in = in_array($status, ['출석', '지각']) ? date('H:i:s') : null;

    $stmt->execute([
        'student_id' => $student_id,
        'check_date' => $check_date,
        'status'     => $status,
        'check_in'   => $check_in,
        'status2'    => $status,
        'check_in2'  => $check_in
    ]);
}

$year_month = $_POST['year_month'] ?? date('Y-m');
header('Location: list.php?student_id=' . urlencode($student_id) . '&ym=' . urlencode($year_month));
exit;