<?php
// student/list.php


require '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'parent') {
    die('접근 권한이 없습니다.');
}

$stmt = $pdo->prepare("SELECT * FROM students WHERE parent_id = :parent_id ORDER BY student_id");
$stmt->execute(['parent_id' => $_SESSION['user_id']]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<h2>자녀 등록</h2>

<form action="student_process.php" method="post">
    <input type="hidden" name="action" value="add">

    <label>자녀 이름</label>
    <input type="text" name="name" required>

    <label>학년/반</label>
    <input type="text" name="class_name" placeholder="예: 3학년 2반" required>

    <button type="submit">등록</button>
</form>

<h3>등록된 자녀 목록</h3>
<table border="1" cellpadding="6">
    <tr>
        <th>이름</th>
        <th>학년/반</th>
        <th>처리</th>
    </tr>
    <?php foreach ($students as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['class_name']) ?></td>
            <td>
                <form action="student_process.php" method="post" style="display:inline"
                      onsubmit="return confirm('삭제하시겠습니까?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="student_id" value="<?= $s['student_id'] ?>">
                    <button type="submit">삭제</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>