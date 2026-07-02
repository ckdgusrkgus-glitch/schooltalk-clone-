<?php
// notice/write.php
require '../includes/teacher_check.php';  // 로그인 + 교사 권한 재검증
require '../config/db.php';
require '../includes/header.php';

$notice = ['notice_id' => '', 'title' => '', 'content' => ''];

// 수정 모드: URL에 id가 있으면 기존 데이터 불러오기
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM notices WHERE notice_id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $notice = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h2><?= $notice['notice_id'] ? '공지 수정' : '공지 작성' ?></h2>

<form action="notice_process.php" method="post">
    <input type="hidden" name="notice_id" value="<?= htmlspecialchars($notice['notice_id']) ?>">

    <label>제목</label>
    <input type="text" name="title" value="<?= htmlspecialchars($notice['title']) ?>" required>

    <label>내용</label>
    <textarea name="content" required><?= htmlspecialchars($notice['content']) ?></textarea>

    <button type="submit">저장</button>
</form>
<?php require '../includes/footer.php'; ?>