<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// 본인 글인지 확인하고 삭제
$sql = "DELETE FROM posts WHERE id = $id AND user_id = $user_id";
if ($conn->query($sql)) {
    header("Location: list.php");
    exit();
} else {
    echo "삭제 실패: " . $conn->error;
}
