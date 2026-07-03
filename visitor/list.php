<?php
// visitor/list.php
require '../includes/teacher_check.php';
require '../config/db.php';

$stmt = $pdo->query("SELECT v.*, u.name AS parent_name FROM visitor_reservations v
                      JOIN users u ON v.parent_id = u.user_id ORDER BY v.visit_date, v.visit_time");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$active_menu = 'visitor';
require '../includes/header.php';
?>

<h2>방문자 예약 관리</h2>

<table>
    <tr><th>신청자</th><th>날짜</th><th>시간</th><th>목적</th><th>상태</th><th>처리</th></tr>
    <?php foreach ($reservations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['parent_name']) ?></td>
            <td><?= htmlspecialchars($r['visit_date']) ?></td>
            <td><?= htmlspecialchars($r['visit_time']) ?></td>
            <td><?= htmlspecialchars($r['purpose']) ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td>
                <?php if ($r['status'] === '신청'): ?>
                    <form action="visitor_process.php" method="post" style="display:inline">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="reservation_id" value="<?= $r['reservation_id'] ?>">
                        <input type="hidden" name="new_status" value="승인">
                        <button type="submit" class="btn btn-small">승인</button>
                    </form>
                    <form action="visitor_process.php" method="post" style="display:inline">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="reservation_id" value="<?= $r['reservation_id'] ?>">
                        <input type="hidden" name="new_status" value="거절">
                        <button type="submit" class="btn btn-small">거절</button>
                    </form>
                <?php else: ?>-<?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>