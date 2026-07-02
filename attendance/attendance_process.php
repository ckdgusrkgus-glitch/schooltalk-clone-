<?php
// attendance/attendance_process.php
require '../includes/teacher_check.php';
require '../config/db.php';

$check_date = $_POST['check_date'] ?? '';
$status_list = $_POST['status'] ?? [];  // ['1' => '출석', '2' => '지각', ...]

if ($check_date === '' || empty($status_list)) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO attendance (student_id, check_date, status, check_in)
    VALUES (:student_id, :check_date, :status, :check_in)
    ON DUPLICATE KEY UPDATE status = :status2, check_in = :check_in2
");

foreach ($status_list as $student_id => $status) {
    // 출석/지각인 경우만 등원 시간 기록, 결석은 NULL
    $check_in = in_array($status, ['출석', '지각']) ? date('H:i:s') : null;

    $stmt->execute([
        'student_id'  => $student_id,
        'check_date'  => $check_date,
        'status'      => $status,
        'check_in'    => $check_in,
        'status2'     => $status,
        'check_in2'   => $check_in
    ]);
}

header('Location: list.php?date=' . urlencode($check_date));
exit;