<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = $_GET['id'];

// 게시글 불러오기
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

<h2>📄 게시글 상세보기</h2>
<p><strong>Title:</strong> <?= htmlspecialchars($post['title']) ?></p>
<p><strong>Author:</strong> <?= $post['name'] ?> | <?= $post['created_at'] ?></p>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

<hr>
<a href="list.php">List</a>
<a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
<a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('정말 삭제할까요?');">Delete</a>
<a href="write.php">Write</a>
<a href="logout.php">Logout</a>
