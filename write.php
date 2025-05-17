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

    $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit();
    } else {
        echo "글 저장 실패: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Bulletin Board > Writing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            margin: 50px auto;
            border: 1px solid #000;
            padding: 20px;
        }
        h2 {
            margin-top: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
        }
        label {
            display: inline-block;
            width: 80px;
            margin-bottom: 10px;
        }
        input[type="text"], textarea {
            width: 450px;
            padding: 6px;
            border: 1px solid #aaa;
        }
        textarea {
            height: 120px;
            resize: none;
        }
        .buttons {
            margin-top: 20px;
            text-align: center;
        }
        .buttons input, .buttons a {
            display: inline-block;
            width: 80px;
            padding: 6px;
            margin: 0 5px;
            background-color: #eee;
            border: 1px solid #aaa;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bulletin Board > Writing</h2>
    <form method="post" onsubmit="return validateForm();">
        <label>Title</label>
        <input type="text" name="title" required><br>
        <label>Content</label>
        <textarea name="content" required></textarea><br>

        <div class="buttons">
            <input type="submit" value="Save">
            <a href="list.php">List</a>
            <a href="logout.php">Logout</a>
        </div>
    </form>
</div>

<script>
function validateForm() {
    const title = document.forms[0]["title"].value.trim();
    const content = document.forms[0]["content"].value.trim();

    if (!title || !content) {
        alert("제목과 내용을 모두 입력해주세요.");
        return false;
    }
    return true;
}
</script>

</body>
</html>
