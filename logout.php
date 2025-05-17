<?php
session_start();
session_destroy(); // 세션 종료
header("Location: index.php"); // 로그인 화면으로 이동
exit();
