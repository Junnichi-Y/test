<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['login'])==false){
        echo 'ログインされていません。<br>';
        echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
        exit();
    }
    if (isset($_POST['add'])==true) {
        header('Location: staff_add.php');
        exit();
    }
    if (isset($_POST['staffcode'])==false) {
        header('Location: staff_ng.php');
        exit();
    }
    elseif (isset($_POST['disp'])==true) {
        $staff_code=$_POST['staffcode'];
        header('Location: staff_disp.php?staffcode='.$staff_code);
        exit();
    }
    elseif (isset($_POST['edit'])==true) {
        $staff_code=$_POST['staffcode'];
        header('Location: staff_edit.php?staffcode='.$staff_code);
        exit();
    }
    elseif (isset($_POST['delete'])==true) {
        $staff_code=$_POST['staffcode'];
        header('Location: staff_delete.php?staffcode='.$staff_code);
        exit();
    }
?>