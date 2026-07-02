<?php
// visitor/apply.php
require '../includes/auth_check.php';
require '../config/db.php';
require '../includes/header.php';

if ($_SESSION['role'] !== 'parent') {
    die('접근 권한이 없습니다.');
}

// 본인이 신청한 예약 목록도 같이 보여주기
$stmt = $pdo->prepare("
    SELECT * FROM visitor_reservations
    WHERE parent_id = :parent_id
    ORDER BY visit_date DESC, visit_time DESC
");
$stmt->execute(['parent_id' => $_SESSION['user_id']]);
$my_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>방문자 예약 신청</h2>

<form action="visitor_process.php" method="post">
    <input type="hidden" name="action" value="apply">

    <label>방문 날짜</label>
    <input type="date" name="visit_date" required>

    <label>방문 시간</label>
    <input type="time" name="visit_time" required>

    <label>방문 목적</label>
    <input type="text" name="purpose" maxlength="200" required>

    <button type="submit">신청</button>
</form>

<h3>내 예약 내역</h3>
<table border="1" cellpadding="6">
    <tr>
        <th>날짜</th>
        <th>시간</th>
        <th>목적</th>
        <th>상태</th>
    </tr>
    <?php foreach ($my_reservations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['visit_date']) ?></td>
            <td><?= htmlspecialchars($r['visit_time']) ?></td>
            <td><?= htmlspecialchars($r['purpose']) ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php require '../includes/footer.php'; ?>