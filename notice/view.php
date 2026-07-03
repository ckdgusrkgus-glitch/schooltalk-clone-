<?php
// notice/view.php
require '../includes/auth_check.php';
require '../config/db.php';

$notice_id = $_GET['id'] ?? '';
$stmt = $pdo->prepare("SELECT n.*, u.name AS writer_name FROM notices n
                        JOIN users u ON n.writer_id = u.user_id WHERE n.notice_id = :id");
$stmt->execute(['id' => $notice_id]);
$notice = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$notice) { die('존재하지 않는 공지입니다.'); }

$active_menu = 'notice';
require '../includes/header.php';
?>

<h2><?= htmlspecialchars($notice['title']) ?></h2>
<p>작성자: <?= htmlspecialchars($notice['writer_name']) ?> / 작성일: <?= htmlspecialchars($notice['created_at']) ?></p>
<div style="background:var(--input-bg); border-radius:var(--radius-input); padding:20px; min-height:200px;">
    <?= nl2br(htmlspecialchars($notice['content'])) ?>
</div>

<div style="display:flex; gap:12px; margin-top:24px;">
    <a href="list.php" class="btn">목록</a>
    <?php if ($_SESSION['role'] === 'teacher'): ?>
        <a href="write.php?id=<?= $notice['notice_id'] ?>" class="btn">수정</a>
        <a href="notice_process.php?action=delete&id=<?= $notice['notice_id'] ?>"
           class="btn" onclick="return confirm('삭제하시겠습니까?')">삭제</a>
    <?php endif; ?>
</div>

<?php require '../includes/footer.php'; ?>