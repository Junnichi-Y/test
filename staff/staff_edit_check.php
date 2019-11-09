<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo 'ログインされていません。<br>';
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
        exit();
    }
    else {
        echo $_SESSION['staff_name'];
        echo 'さんログイン中 <br>';
        echo '<br>';
    }
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
    <?php
    require_once('../common/common.php');

    $post=sanitize($_POST);
    $staff_code=$post['code'];
    $staff_name=$post['name'];
    $staff_pass=$post['pass'];
    $staff_pass2=$post['pass2'];
    
    if($staff_name==''){
        echo 'スタッフ名が入力されていません。<br>';
    }
    else{
        echo 'スタッフ名：';
        echo $staff_name;
        echo '<br>';
    }
    if($staff_pass==''){
        echo 'パスワードが入力されていません。<br>';
    }
    if($staff_pass2!=$staff_pass){
        echo 'パスワードが一致しません。<br>';
    }
    if($staff_name=='' || $staff_pass=='' || $staff_pass!=$staff_pass2){
        echo'<from>';
        echo'<input type="button" onclick="history.back()" value="戻る">';
        echo '</from>';
    }
    else{
        $staff_pass=md5($staff_pass);
        echo '<form method="post" action="staff_edit_done.php">';
        echo '<input type="hidden" name="code" value="'.$staff_code.'">';
        echo '<input type="hidden" name="name" value="'.$staff_name.'">';
        echo '<input type="hidden" name="pass" value="'.$staff_pass.'">'.'<br>';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        echo '<input type="submit" value="OK">';
        echo '</form>';
    }
    ?>
</body>
</html>