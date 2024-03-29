<?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['member_login'])==false){
        echo 'ようこそゲスト様　';
        echo '<a href="member_login.html">会員ログイン</a><br>';
        echo '<br>';
    }
    else {
        echo 'ようこそ';
        echo $_SESSION['member_name'];
        echo '様　';
        echo '<a href="member_logout.php">ログアウト</a><br>';
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
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $use = 'root';
            $password = '';
            $dbh = new PDO($dsn,$use,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $dbh = null;

            echo '商品一覧 <br /><br />';

            while(true){
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec==false) {
                    break;
                }
                echo '<a href="shop_product.php?procode='.$rec['code'].'">';
                echo $rec['name'].'---';
                echo $rec['price'].'円';
                echo '</a>';
                echo '<br />';
            }
        } catch (Exception $e) {
            echo 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
    ?>
</body>
</html>