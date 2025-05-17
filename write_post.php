<?php
session_start();
include "db.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "로그인이 필요합니다."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {
        echo json_encode(["success" => false, "message" => "제목과 내용을 입력해주세요."]);
        exit;
    }

    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "글 저장 실패: " . $conn->error]);
    }
}
?>
