<?php
// attendance/view.php
require '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'parent') { die('접근 권한이 없습니다.'); }

$year_month = $_GET['ym'] ?? date('Y-m');

$stmt = $pdo->prepare("
    SELECT a.check_date, a.status
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    WHERE s.parent_id = :parent_id AND DATE_FORMAT(a.check_date, '%Y-%m') = :ym
");
$stmt->execute(['parent_id' => $_SESSION['user_id'], 'ym' => $year_month]);
$records = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    $records[$r['check_date']] = $r['status'];
}

$active_menu = 'attendance';
require '../includes/header.php';
?>

<h2>자녀 출결 조회</h2>

<form method="get" style="display:flex; gap:8px; align-items:center; margin-bottom:16px;">
    <select name="ym" onchange="this.form.submit()" style="width:auto; padding:10px;">
        <?php for ($m = 1; $m <= 12; $m++):
            $val = date('Y') . '-' . str_pad($m, 2, '0', STR_PAD_LEFT); ?>
            <option value="<?= $val ?>" <?= $val === $year_month ? 'selected' : '' ?>><?= $val ?></option>
        <?php endfor; ?>
    </select>
</form>

<div class="attendance-grid">
    <div class="day-label sun">일</div><div class="day-label">월</div><div class="day-label">화</div>
    <div class="day-label">수</div><div class="day-label">목</div><div class="day-label">금</div>
    <div class="day-label sat">토</div>

    <?php
    $first_day_weekday = date('w', strtotime($year_month . '-01'));
    for ($i = 0; $i < $first_day_weekday; $i++) {
        echo '<div class="status-cell status-cell-empty"></div>';
    }

    $days_in_month = date('t', strtotime($year_month . '-01'));
    for ($d = 1; $d <= $days_in_month; $d++):
        $date_str = $year_month . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
        $status = $records[$date_str] ?? null;
        if (!$status) { echo '<div class="status-cell status-cell-empty"><span class="date">' . $d . '</span></div>'; continue; }
    ?>
        <div class="status-cell" data-status="<?= $status ?>">
            <span class="date"><?= $d ?></span>
            <span class="status-text"><?= $status ?></span>
        </div>
    <?php endfor; ?>
</div>

<?php require '../includes/footer.php'; ?>