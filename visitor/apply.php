<?php
// visitor/apply.php
require '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'parent') { die('접근 권한이 없습니다.'); }

$stmt = $pdo->prepare("SELECT * FROM visitor_reservations WHERE parent_id = :parent_id ORDER BY visit_date DESC");
$stmt->execute(['parent_id' => $_SESSION['user_id']]);
$my_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$active_menu = 'visitor';
require '../includes/header.php';
?>

<h2>방문자 예약 신청</h2>

<form action="visitor_process.php" method="post">
    <input type="hidden" name="action" value="apply">
    <label>방문 날짜</label>
    <input type="date" name="visit_date" required>

    <label>방문 시간</label>
    <input type="time" name="visit_time" required>

    <label>방문 목적</label>
    <input type="text" name="purpose" required>

    <button type="submit" class="btn btn-block">신청</button>
</form>

<h2 style="margin-top:40px;">내 예약 내역</h2>
<table>
    <tr><th>날짜</th><th>시간</th><th>목적</th><th>상태</th></tr>
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