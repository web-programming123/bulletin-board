<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 300px;
            border: 1px solid #000;
            padding: 20px;
            margin: 100px auto;
            box-shadow: 2px 2px 10px #ccc;
        }
        h2 {
            margin-top: 0;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="password"] {
            width: 95%;
            padding: 5px;
            margin-top: 3px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 8px;
            background-color: #ddd;
            border: 1px solid #aaa;
            font-weight: bold;
            cursor: pointer;
        }
        a {
            display: block;
            margin-top: 10px;
            text-align: right;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="userid">User ID</label>
        <input type="text" id="userid" name="userid" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <a href="signup.php">[회원가입]</a>
</div>

</body>
</html>

