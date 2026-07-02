<?php
// visitor/visitor_process.php
require '../includes/auth_check.php';
require '../config/db.php';

$action = $_POST['action'] ?? '';

// ── 학부모: 방문 예약 신청 ──
if ($action === 'apply') {
    if ($_SESSION['role'] !== 'parent') {
        die('접근 권한이 없습니다.');
    }

    $visit_date = $_POST['visit_date'] ?? '';
    $visit_time = $_POST['visit_time'] ?? '';
    $purpose    = $_POST['purpose'] ?? '';

    // 중복 예약 확인: 같은 날짜/시간에 이미 승인된 예약이 있는지
    $check = $pdo->prepare("
        SELECT COUNT(*) FROM visitor_reservations
        WHERE visit_date = :visit_date
          AND visit_time = :visit_time
          AND status = '승인'
    ");
    $check->execute(['visit_date' => $visit_date, 'visit_time' => $visit_time]);

    if ($check->fetchColumn() > 0) {
        echo "<script>alert('해당 시간에는 이미 예약이 있습니다.'); history.back();</script>";
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO visitor_reservations (parent_id, visit_date, visit_time, purpose)
        VALUES (:parent_id, :visit_date, :visit_time, :purpose)
    ");
    $stmt->execute([
        'parent_id'  => $_SESSION['user_id'],
        'visit_date' => $visit_date,
        'visit_time' => $visit_time,
        'purpose'    => $purpose
    ]);

    header('Location: apply.php');
    exit;
}

// ── 교사: 승인/거절 처리 ──
if ($action === 'update_status') {
    if ($_SESSION['role'] !== 'teacher') {
        die('접근 권한이 없습니다.');
    }

    $reservation_id = $_POST['reservation_id'] ?? '';
    $new_status     = $_POST['new_status'] ?? '';

    if (!in_array($new_status, ['승인', '거절'])) {
        die('잘못된 요청입니다.');
    }

    // 승인 처리 전, 같은 시간대에 이미 승인된 다른 건이 있는지 재확인
    if ($new_status === '승인') {
        $stmt = $pdo->prepare("SELECT visit_date, visit_time FROM visitor_reservations WHERE reservation_id = :id");
        $stmt->execute(['id' => $reservation_id]);
        $target = $stmt->fetch(PDO::FETCH_ASSOC);

        $check = $pdo->prepare("
            SELECT COUNT(*) FROM visitor_reservations
            WHERE visit_date = :visit_date AND visit_time = :visit_time
              AND status = '승인' AND reservation_id != :id
        ");
        $check->execute([
            'visit_date' => $target['visit_date'],
            'visit_time' => $target['visit_time'],
            'id'         => $reservation_id
        ]);

        if ($check->fetchColumn() > 0) {
            echo "<script>alert('해당 시간에는 이미 승인된 예약이 있습니다.'); history.back();</script>";
            exit;
        }
    }

    $stmt = $pdo->prepare("UPDATE visitor_reservations SET status = :status WHERE reservation_id = :id");
    $stmt->execute(['status' => $new_status, 'id' => $reservation_id]);

    header('Location: list.php');
    exit;
}