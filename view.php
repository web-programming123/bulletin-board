<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = intval($_GET['id']); // 보안: 정수로 캐스팅

$sql = "SELECT posts.*, users.name 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    die("해당 글을 찾을 수 없습니다.");
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Bulletin Board > Viewing Content</title>
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
            margin: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
        }
        .meta {
            margin-top: 10px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }
        .content {
            margin-top: 20px;
            white-space: pre-line;
        }
        .button-group {
            margin-top: 20px;
            text-align: center;
        }
        .button-group a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 4px;
            background-color: #eee;
            border: 1px solid #aaa;
            text-decoration: none;
            color: black;
            font-weight: bold;
            width: 80px;
            text-align: center;
        }
        .button-group a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bulletin Board > Viewing Content</h2>

    <p><strong>Title:</strong> <?= htmlspecialchars($post['title']) ?></p>

    <div class="meta">
        <div><?= htmlspecialchars($post['name']) ?></div>
        <div><?= date("d/m/Y", strtotime($post['created_at'])) ?></div>
    </div>

    <div class="content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <div class="button-group">
        <a href="list.php">List</a>
        <a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
        <a href="#" onclick="deletePost(<?= $post['id'] ?>); return false;">Delete</a>
        <a href="write.php">Write</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<script>
function deletePost(id) {
    if (!confirm("정말 삭제할까요?")) return;

    fetch("delete_post.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + encodeURIComponent(id)
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("삭제되었습니다.");
            location.href = "list.php";
        } else {
            alert("❌ " + data);
        }
    })
    .catch(err => {
        alert("오류 발생: " + err);
    });
}
</script>

</body>
</html>