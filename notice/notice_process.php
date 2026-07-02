<?php
// notice/notice_process.php
require '../includes/teacher_check.php';  // 로그인 + 교사 권한 재검증
require '../config/db.php';

// 삭제 요청 처리 (list.php에서 GET으로 넘어옴)
if (($_GET['action'] ?? '') === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM notices WHERE notice_id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    header('Location: list.php');
    exit;
}

// 작성/수정 요청 처리 (write.php의 form에서 POST로 넘어옴)
$notice_id = $_POST['notice_id'] ?? '';
$title     = $_POST['title'] ?? '';
$content   = $_POST['content'] ?? '';

if ($notice_id === '') {
    // 새 공지 작성
    $stmt = $pdo->prepare("INSERT INTO notices (writer_id, title, content)
                            VALUES (:writer_id, :title, :content)");
    $stmt->execute([
        'writer_id' => $_SESSION['user_id'],
        'title'     => $title,
        'content'   => $content
    ]);
} else {
    // 기존 공지 수정
    $stmt = $pdo->prepare("UPDATE notices SET title = :title, content = :content
                            WHERE notice_id = :id");
    $stmt->execute([
        'title'   => $title,
        'content' => $content,
        'id'      => $notice_id
    ]);
}

header('Location: list.php');
exit;