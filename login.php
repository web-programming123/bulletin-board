<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE userid = '$userid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // 로그인 성공 → 세션에 정보 저장
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            header("Location: list.php");
            exit();
        } else {
            echo "비밀번호가 틀렸습니다.";
        }
    } else {
        echo "존재하지 않는 사용자입니다.";
    }
}
?>
