<?php
session_start();
include "db.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "로그인이 필요합니다."]);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$title = trim($_POST["title"] ?? "");
$content = trim($_POST["content"] ?? "");
$user_id = intval($_SESSION["user_id"]);

// 유효성 검사
if (!$id || $title === "" || $content === "") {
    echo json_encode(["success" => false, "message" => "모든 항목을 입력해주세요."]);
    exit;
}

// 글 소유 확인
$sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode(["success" => false, "message" => "수정 권한이 없습니다."]);
    exit;
}

// 수정 실행
$update_sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("ssi", $title, $content, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "수정 실패: " . $conn->error]);
}
?>
