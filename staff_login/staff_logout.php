<?php
    session_start();
    $_SESSION=array();
    if(isset($_COOKIE[session_name()])==true){
        setcookie(session_name(),'',time()-42000,'/');
    }
    session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>インテリア市場</title>
</head>
<body>
    ログアウトしました。<br>
    <br>
    <a href="../staff_login/staff_login.html">ログイン画面へ</a>
</body>
</html>