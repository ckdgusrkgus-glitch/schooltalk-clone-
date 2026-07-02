<?php
// notice/list.php
require '../includes/auth_check.php';  // 로그인 안 되어 있으면 여기서 걸러짐
require '../config/db.php';
require '../includes/header.php';

$stmt = $pdo->query("SELECT n.*, u.name AS writer_name
                      FROM notices n
                      JOIN users u ON n.writer_id = u.user_id
                      ORDER BY n.created_at DESC");
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>학교 알림</h2>

<?php if ($_SESSION['role'] === 'teacher'): ?>
    <a href="write.php">+ 공지 작성</a>
<?php endif; ?>

<ul>
<?php foreach ($notices as $n): ?>
    <li>
        <strong><a href="view.php?id=<?= $n['notice_id'] ?>"><?= htmlspecialchars($n['title']) ?></a></strong>
        (<?= htmlspecialchars($n['writer_name']) ?> / <?= $n['created_at'] ?>)

        <?php if ($_SESSION['role'] === 'teacher'): ?>
            <a href="write.php?id=<?= $n['notice_id'] ?>">수정</a>
            <a href="notice_process.php?action=delete&id=<?= $n['notice_id'] ?>"
               onclick="return confirm('삭제하시겠습니까?')">삭제</a>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
<?php require '../includes/footer.php'; ?>