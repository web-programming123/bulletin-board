<?php
include "db.php";

// 회원가입 폼 전송 시 실행
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // 비밀번호 암호화
    $name = $_POST["name"];
    $email = $_POST["email"];

    // 중복 체크
    $check_sql = "SELECT * FROM users WHERE userid = '$userid'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "이미 존재하는 아이디입니다.";
    } else {
        $sql = "INSERT INTO users (userid, password, name, email)
                VALUES ('$userid', '$password', '$name', '$email')";
        
        if ($conn->query($sql)) {
            header("Location: index.php"); // 성공 시 로그인 화면으로 이동
            exit();
        } else {
            echo "회원가입 실패: " . $conn->error;
        }
    }
}
?>

<h2>회원가입</h2>
<form method="post" action="">
    User ID: <input type="text" name="userid" required><br>
    Password: <input type="password" name="password" required><br>
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    <input type="submit" value="Sign Up">
</form>

<a href="index.php">[로그인 화면으로]</a>
<!-- JS 검증 스크립트는 여기 -->
<script>
function validateForm() {
  const userid = document.forms[0]["userid"].value;
  const password = document.forms[0]["password"].value;
  const confirm = document.forms[0]["password_confirm"].value;
  const name = document.forms[0]["name"].value;
  const email = document.forms[0]["email"].value;

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
