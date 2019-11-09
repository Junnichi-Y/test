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
    try {
        require_once('../common/common.php');

        $post=sanitize($_POST);
        $staff_code=$post['code'];
        $staff_name=$post['name'];
        $staff_pass=$post['pass'];

        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $use = 'root';
        $password = '';
        $dbh = new PDO($dsn,$use,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql = 'UPDATE mst_staff SET name=?,password=? WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $staff_name;
        $data[] = $staff_pass;
        $data[] = $staff_code;
        $stmt->execute($data);

        $dbh = null;

    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }
    ?>
    修正しました。<br>
    <br>
    <a href="staff_list.php">戻る</a>
</body>
</html>