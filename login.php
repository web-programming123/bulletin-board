<?php
session_start();
include "db.php"; // DB 연결

$userid = $_POST['userid'];
$password = $_POST['password'];

// ID 존재 확인
$sql = "SELECT * FROM users WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // ID가 없음 → 회원가입 페이지로 리디렉션
    header("Location: signup.php");
    exit;
}

// 로그인 처리
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['name'] = $user['name'];
    header("Location: board.php"); // 로그인 성공 시 게시판으로 이동
    exit;
} else {
    echo "<script>alert('비밀번호가 틀렸습니다.');history.back();</script>";
}
?>
