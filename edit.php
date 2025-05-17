<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = $_GET['id'];

// 게시글 불러오기
$sql = "SELECT * FROM posts WHERE id = $id AND user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    die("글을 수정할 권한이 없습니다.");
}
$post = $result->fetch_assoc();

// 수정 완료 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update_sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    if ($conn->query($update_sql)) {
        header("Location: view.php?id=$id");
        exit();
    } else {
        echo "수정 실패: " . $conn->error;
    }
}
?>

<h2>✏️ 글 수정</h2>
<form method="post">
    제목: <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"><br><br>
    내용:<br>
    <textarea name="content" rows="10" cols="50"><?= htmlspecialchars($post['content']) ?></textarea><br><br>
    <input type="submit" value="저장">
</form>

<a href="list.php">List</a>
