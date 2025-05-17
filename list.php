<?php
session_start();
include "db.php";

// 로그인한 사용자만 접근 가능
if (!isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}

// 게시글 목록 불러오기 (id 내림차순)
$sql = "SELECT posts.id, title, name, created_at 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Bulletin Board</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .board-container {
            width: 600px;
            border: 1px solid #000;
            padding: 20px;
            margin: 50px auto;
        }
        h2 {
            margin-top: 0;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: none;
            padding: 8px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        a.button {
            display: inline-block;
            padding: 6px 12px;
            margin-top: 20px;
            margin-right: 5px;
            background-color: #ddd;
            border: 1px solid #aaa;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .title-link {
            text-decoration: none;
            color: black;
        }
        .title-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="board-container">
    <h2>Bulletin Board > List View</h2>

    <table>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Name</th>
            <th>Date</th>
        </tr>
        <?php $no = $result->num_rows; ?>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $no-- ?></td>
        <td>
            <a class="title-link" href="view.php?id=<?= $row["id"] ?>">
                <?= htmlspecialchars($row["title"]) ?>
            </a>
        </td>
        <td><?= htmlspecialchars($row["name"]) ?></td>
        <td><?= date("d/m/Y", strtotime($row["created_at"])) ?></td>
    </tr>
<?php endwhile; ?>

    </table>

    <div style="text-align: right;">
        <a class="button" href="write.php">Write</a>
        <a class="button" href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
