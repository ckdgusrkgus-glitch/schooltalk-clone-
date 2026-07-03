<?php
// notice/list.php
require '../includes/auth_check.php';
require '../config/db.php';

$stmt = $pdo->query("SELECT n.*, u.name AS writer_name
                      FROM notices n
                      JOIN users u ON n.writer_id = u.user_id
                      ORDER BY n.created_at DESC");
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);

$active_menu = 'notice';
require '../includes/header.php';
?>

<h2>학교 공지사항</h2>

<?php if ($_SESSION['role'] === 'teacher'): ?>
    <a href="write.php" class="btn btn-small">+ 공지 작성</a>
<?php endif; ?>

<table>
    <?php foreach ($notices as $n): ?>
        <tr>
            <td><a href="view.php?id=<?= $n['notice_id'] ?>"><?= htmlspecialchars($n['title']) ?></a></td>
            <td><?= htmlspecialchars($n['writer_name']) ?></td>
            <td><?= htmlspecialchars($n['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>