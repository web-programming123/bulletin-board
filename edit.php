<?php
session_start();
include "db.php";

// ✅ 로그인 확인
if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다.");
}

// ✅ GET 파라미터 확인
if (!isset($_GET['id'])) {
    die("글 번호가 없습니다.");
}

$id = intval($_GET['id']); // 정수화
$user_id = intval($_SESSION['user_id']); // 로그인된 사용자의 DB ID

// ✅ 게시글 불러오기 + 작성자 확인
$sql = "SELECT posts.*, users.name FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = $id AND posts.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("글을 수정할 권한이 없습니다.");
}

$post = $result->fetch_assoc();

// ✅ 수정 요청 처리
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update_sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        header("Location: view.php?id=$id");
        exit();
    } else {
        echo "수정 실패: " . $conn->error;
    }
}
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
    <form method="post">
        <label>Name</label>
        <input type="text" value="<?= htmlspecialchars($post['name'] ?? '') ?>" readonly><br>
        <label>Password</label>
        <input type="password" value="*******" readonly><br>
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required><br>
        <label>Content</label>
        <textarea name="content" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea><br>

        <div class="buttons">
            <input type="submit" value="Save">
            <a href="list.php">List</a>
            <a href="logout.php">Logout</a>
        </div>
    </form>
</div>

</body>
</html>
