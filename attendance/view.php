<?php
// attendance/view.php
require '../includes/auth_check.php';
require '../config/db.php';
require '../includes/header.php';
// 학부모가 아니면 이 화면에 들어올 이유가 없으므로 차단
if ($_SESSION['role'] !== 'parent') {
    die('접근 권한이 없습니다.');
}

$year  = $_GET['year']  ?? date('Y');
$month = $_GET['month'] ?? date('m');

$stmt = $pdo->prepare("
    SELECT s.name AS student_name, a.check_date, a.status, a.check_in
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    WHERE s.parent_id = :parent_id
      AND YEAR(a.check_date) = :year
      AND MONTH(a.check_date) = :month
    ORDER BY a.check_date
");
$stmt->execute([
    'parent_id' => $_SESSION['user_id'],
    'year'      => $year,
    'month'     => $month
]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>자녀 출결 조회</h2>

<form method="get">
    <input type="number" name="year" value="<?= htmlspecialchars($year) ?>" min="2020" max="2100">년
    <input type="number" name="month" value="<?= htmlspecialchars($month) ?>" min="1" max="12">월
    <button type="submit">조회</button>
</form>

<table border="1" cellpadding="6">
    <tr>
        <th>날짜</th>
        <th>자녀</th>
        <th>상태</th>
        <th>등원 시간</th>
    </tr>
    <?php foreach ($records as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['check_date']) ?></td>
            <td><?= htmlspecialchars($r['student_name']) ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td><?= htmlspecialchars($r['check_in'] ?? '-') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php require '../includes/footer.php'; ?>