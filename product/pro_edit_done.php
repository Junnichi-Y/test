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
        $pro_code=$post['code'];
        $pro_name=$post['name'];
        $pro_price=$post['price'];
        $pro_gazou_name_old=$post['gazou_name_old'];
        $pro_gazou_name=$post['gazou_name'];

        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $use = 'root';
        $password = '';
        $dbh = new PDO($dsn,$use,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql = 'UPDATE mst_product SET name=?,price=?,gazou=? WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $pro_name;
        $data[] = $pro_price;
        $data[] = $pro_gazou_name;
        $data[] = $pro_code;
        $stmt->execute($data);

        $dbh = null;

        if ($pro_gazou_name_old != $pro_gazou_name) {
            if ($pro_gazou_name_old !='') {
                unlink('./gazou/'.$pro_gazou_name_old);
            }
        }

        print '修正しました。<br />';
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }
    ?>
    <a href="pro_list.php">戻る</a>
</body>
</html>