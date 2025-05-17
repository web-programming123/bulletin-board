<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}
if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = intval($_GET['id']);
$user_id = intval($_SESSION['user_id']);

$sql = "SELECT posts.*, users.name FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = $id AND posts.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("글을 수정할 권한이 없습니다.");
}
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Bulletin Board > Editing</title>
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
        input[type="text"],
        input[type="password"],
        textarea {
            width: 450px;
            padding: 6px;
            border: 1px solid #aaa;
        }
        textarea {
            height: 100px;
            resize: none;
        }
        .buttons {
            margin-top: 20px;
            text-align: center;
        }
        .buttons input,
        .buttons a {
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
    <h2>Bulletin Board > Editing</h2>
    <form id="editForm">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">
        <label>Name</label>
        <input type="text" value="<?= htmlspecialchars($post['name']) ?>" readonly><br>
        <label>Password</label>
        <input type="password" value="*******" readonly><br>
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>
        <label>Content</label>
        <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea><br>

        <div class="buttons">
            <input type="submit" value="Save">
            <a href="list.php">List</a>
            <a href="logout.php">Logout</a>
        </div>
    </form>
</div>

<script>
document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const id = form.id.value;
    const title = form.title.value.trim();
    const content = form.content.value.trim();

    if (!title || !content) {
        alert("제목과 내용을 모두 입력해주세요.");
        return;
    }

    const formData = new URLSearchParams();
    formData.append("id", id);
    formData.append("title", title);
    formData.append("content", content);

    fetch("edit_post.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData.toString()
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("수정 완료되었습니다.");
            location.href = "view.php?id=" + id;
        } else {
            alert("❌ " + (data.message || "수정 실패"));
        }
    })
    .catch(err => {
        alert("통신 오류: " + err);
    });
});
</script>

</body>
</html>
