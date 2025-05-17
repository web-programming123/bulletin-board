<?php
include "db.php";

// 회원가입 폼 전송 시 실행
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $password_raw = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    // 서버 측 유효성 검사
    if ($password_raw !== $password_confirm) {
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // 중복 체크
    $check_sql = "SELECT * FROM users WHERE userid = '$userid'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('이미 존재하는 아이디입니다.'); history.back();</script>";
    } else {
        $sql = "INSERT INTO users (userid, password, name, email)
                VALUES ('$userid', '$password', '$name', '$email')";
        
        if ($conn->query($sql)) {
            echo "<script>alert('회원가입 성공!'); location.href='index.php';</script>";
            exit();
        } else {
            echo "회원가입 실패: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원가입</title>
    <script src="js/signup.js"></script>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
        }
        .container {
            width: 400px;
            border: 1px solid #aaa;
            padding: 20px;
        }
        .form-row {
            margin-bottom: 10px;
        }
        label {
            display: inline-block;
            width: 130px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 200px;
        }
        .button-row {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form method="post" onsubmit="return validateForm();">
            <div class="form-row">
                <label>User ID:</label>
                <input type="text" name="userid" id="userid" required>
                <button type="button" onclick="checkDuplicate()">Duplicate Check</button>
            </div>
            <div class="form-row">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-row">
                <label>Password Confirm:</label>
                <input type="password" name="password_confirm" required>
            </div>
            <div class="form-row">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-row">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="button-row">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="location.href='index.php'">
            </div>
        </form>
    </div>

    <script>
    function validateForm() {
        const form = document.forms[0];
        const userid = form["userid"].value;
        const password = form["password"].value;
        const confirm = form["password_confirm"].value;
        const name = form["name"].value;
        const email = form["email"].value;

        if (!userid || !password || !confirm || !name || !email) {
            alert("모든 항목을 입력해주세요.");
            return false;
        }

        if (password !== confirm) {
            alert("비밀번호가 일치하지 않습니다.");
            return false;
        }

        if (!email.includes("@") || !email.includes(".")) {
            alert("이메일 형식이 올바르지 않습니다.");
            return false;
        }

        return true;
    }
    </script>
</body>
</html>
