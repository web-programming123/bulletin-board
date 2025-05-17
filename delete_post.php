<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    echo "로그인이 필요합니다.";
    exit;
}

if (!isset($_POST['id'])) {
    echo "글 번호가 없습니다.";
    exit;
}

$id = intval($_POST['id']);
$user_id = intval($_SESSION['user_id']);

// 본인 글인지 확인
$sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "삭제 권한이 없습니다.";
    exit;
}

// 삭제 수행
$delete_sql = "DELETE FROM posts WHERE id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "삭제 실패";
}
?>
