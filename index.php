<?php
session_start();
?>

<h2>로그인</h2>
<form method="post" action="login.php">
    User ID: <input type="text" name="userid" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>

<a href="signup.php">[회원가입]</a>
