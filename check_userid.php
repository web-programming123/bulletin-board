<?php
include "db.php";

if (!isset($_GET["userid"])) {
    echo "아이디가 전달되지 않았습니다.";
    exit;
}

$userid = $_GET["userid"];

$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "이미 사용 중인 아이디입니다.";
} else {
    echo "사용 가능한 아이디입니다.";
}
?>
