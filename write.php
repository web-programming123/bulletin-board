<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
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
    <form id="writeForm">
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
document.getElementById("writeForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const title = form.title.value.trim();
    const content = form.content.value.trim();

    if (!title || !content) {
        alert("제목과 내용을 모두 입력해주세요.");
        return;
    }

    const formData = new URLSearchParams();
    formData.append("title", title);
    formData.append("content", content);

    fetch("write_post.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData.toString()
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("게시글이 등록되었습니다.");
            location.href = "list.php";
        } else {
            alert("❌ " + (data.message || "등록 실패"));
        }
    })
    .catch(err => {
        alert("통신 오류: " + err);
    });
});
</script>

</body>
</html>
