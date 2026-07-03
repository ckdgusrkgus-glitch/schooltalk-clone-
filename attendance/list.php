<?php
// attendance/list.php
require '../includes/teacher_check.php';
require '../config/db.php';

// 전체 학생 목록 (드롭다운용)
$student_list = $pdo->query("SELECT student_id, name, class_name FROM students ORDER BY class_name, name")->fetchAll(PDO::FETCH_ASSOC);

// 선택된 학생 (기본값: 첫 번째 학생)
$student_id = $_GET['student_id'] ?? ($student_list[0]['student_id'] ?? '');
$year_month = $_GET['ym'] ?? date('Y-m');

// 선택된 학생의 해당 월 출결 기록 조회
$records = [];
if ($student_id) {
    $stmt = $pdo->prepare("
        SELECT check_date, status FROM attendance
        WHERE student_id = :student_id
          AND DATE_FORMAT(check_date, '%Y-%m') = :ym
    ");
    $stmt->execute(['student_id' => $student_id, 'ym' => $year_month]);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
        $records[$r['check_date']] = $r['status'];
    }
}

$active_menu = 'attendance';
require '../includes/header.php';
?>

<h2>출결 관리</h2>

<form method="get" style="display:flex; gap:12px; margin-bottom:16px;">
    <select name="student_id" onchange="this.form.submit()" style="width:auto; padding:10px;">
        <?php foreach ($student_list as $s): ?>
            <option value="<?= $s['student_id'] ?>" <?= (string)$s['student_id'] === (string)$student_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['class_name']) ?> <?= htmlspecialchars($s['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="month" name="ym" value="<?= htmlspecialchars($year_month) ?>" onchange="this.form.submit()">
</form>

<form action="attendance_process.php" method="post" id="attendance-form">
    <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_id) ?>">
    <input type="hidden" name="year_month" value="<?= htmlspecialchars($year_month) ?>">

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
            $status = $records[$date_str] ?? '출석';
        ?>
            <div class="status-cell" data-date="<?= $date_str ?>" data-status="<?= $status ?>" onclick="cycleStatus(this)">
                <span class="date"><?= $d ?></span>
                <span class="status-text"><?= $status ?></span>
            </div>
        <?php endfor; ?>
    </div>

    <button type="submit" class="btn btn-block">저장</button>
</form>

<?php require '../includes/footer.php'; ?>