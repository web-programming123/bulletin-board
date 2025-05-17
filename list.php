<?php
session_start();
include "db.php";

// 로그인한 사용자만 접근 가능
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// 게시글 목록 불러오기
$sql = "SELECT posts.id, title, name, created_at 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.id DESC";
$result = $conn->query($sql);
?>

<h2>📋 게시판 글 목록</h2>
<p>안녕하세요, <?= $_SESSION["user_name"] ?>님!</p>
<a href="write.php">[글쓰기]</a> | <a href="logout.php">[로그아웃]</a>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>제목</th>
        <th>작성자</th>
        <th>작성일</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><a href="view.php?id=<?= $row["id"] ?>"><?= htmlspecialchars($row["title"]) ?></a></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["created_at"] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
