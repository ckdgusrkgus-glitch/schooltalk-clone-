<?php
// attendance/list.php
require '../includes/teacher_check.php';
require '../config/db.php';
require '../includes/header.php';

// 날짜 선택 (기본값: 오늘)
$check_date = $_GET['date'] ?? date('Y-m-d');

// 전체 학생 목록 + 해당 날짜의 기존 출결 기록(있으면) 같이 조회
$stmt = $pdo->prepare("
    SELECT s.student_id, s.name, s.class_name,
           a.status, a.check_in
    FROM students s
    LEFT JOIN attendance a
        ON s.student_id = a.student_id AND a.check_date = :check_date
    ORDER BY s.class_name, s.name
");
$stmt->execute(['check_date' => $check_date]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>출결 관리</h2>

<form method="get">
    <label>날짜 선택</label>
    <input type="date" name="date" value="<?= htmlspecialchars($check_date) ?>"
           onchange="this.form.submit()">
</form>

<form action="attendance_process.php" method="post">
    <input type="hidden" name="check_date" value="<?= htmlspecialchars($check_date) ?>">

    <table border="1" cellpadding="6">
        <tr>
            <th>반</th>
            <th>이름</th>
            <th>출석</th>
            <th>지각</th>
            <th>결석</th>
        </tr>
        <?php foreach ($students as $s): ?>
            <?php $current = $s['status'] ?? '출석'; ?>
            <tr>
                <td><?= htmlspecialchars($s['class_name']) ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <?php foreach (['출석', '지각', '결석'] as $option): ?>
                    <td>
                        <input type="radio"
                               name="status[<?= $s['student_id'] ?>]"
                               value="<?= $option ?>"
                               <?= $current === $option ? 'checked' : '' ?>>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <button type="submit">저장</button>
</form>
<?php require '../includes/footer.php'; ?>