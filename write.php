<?php
session_start();
include "db.php";

// 로그인 여부 확인
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// 글 작성 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO posts (title, content, user_id) 
            VALUES ('$title', '$content', $user_id)";
    if ($conn->query($sql)) {
        header("Location: list.php");
        exit();
    } else {
        echo "글 저장 실패: " . $conn->error;
    }
}
?>

<h2>✍️ 글쓰기</h2>
<form method="post" action="">
    제목: <input type="text" name="title" required><br><br>
    내용:<br>
    <textarea name="content" rows="10" cols="50" required></textarea><br><br>
    <input type="submit" value="저장">
</form>

<a href="list.php">[목록으로]</a>
<form method="post" onsubmit="return validateWriteForm()">
  제목: <input type="text" name="title"><br>
  내용: <textarea name="content"></textarea><br>
  <input type="submit" value="저장">
</form>

<script>
function validateWriteForm() {
  const title = document.forms[0]["title"].value.trim();
  const content = document.forms[0]["content"].value.trim();

  if (!title || !content) {
    alert("제목과 내용을 모두 입력해주세요.");
    return false;
  }
  return true;
}
</script>
