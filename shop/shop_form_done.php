<?php
    session_start();
    session_regenerate_id(true);
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

            $onamae=$post['onamae'];
            $email=$post['email'];
            $postal1=$post['postal1'];
            $postal2=$post['postal2'];
            $address=$post['address'];
            $tel=$post['tel'];

            echo $onamae.'様<br>';
            echo 'ご注文ありがとうございました。<br>';
            echo $email.'宛に確認用メールを送りました。<br>';
            echo '商品は準備でき次第、以下の住所に発送させていただきます。<br>';
            echo $postal1.'-'.$postal2.'<br>';
            echo $address.'<br>';
            echo $tel.'<br>';

            $honbun='';
            $honbun.=$onamae."様\n\nこの度はご注文ありがとうございました。\n";
            $honbun.="\n";
            $honbun.="ご注文商品\n";
            $honbun.="--------------------\n";

            $cart=$_SESSION['cart'];
            $kazu=$_SESSION['kazu'];
            $max=count($cart);

            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $use = 'root';
            $password = '';
            $dbh = new PDO($dsn,$use,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            for ($i=0; $i < $max; $i++) {
                $sql = 'SELECT name,price FROM mst_product WHERE code=?';
                $stmt = $dbh->prepare($sql);
                $data[0]=$cart[$i];
                $stmt->execute($data);

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);

                $name=$rec['name'];
                $price=$rec['price'];
                $kakaku[]=$price;
                $suryo=$kazu[$i];
                $shokei=$price * $suryo;

                $honbun.=$name.'　';
                $honbun.=$price.'円 x ';
                $honbun.=$suryo.'個 = ';
                $honbun.=$shokei."円\n";
            }

            $sql = 'LOCK TABLES dat_sales WRITE,dat_sales_product WRITE';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $sql = 'INSERT INTO dat_sales(code_member,name,email,postal1,postal2,address,tel) VALUES(?,?,?,?,?,?,?)';
            $stmt = $dbh->prepare($sql);
            $data = array();
            $data[]=0;
            $data[]=$onamae;
            $data[]=$email;
            $data[]=$postal1;
            $data[]=$postal2;
            $data[]=$address;
            $data[]=$tel;
            $stmt->execute($data);

            $sql = 'SELECT LAST_INSERT_ID()';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastcode = $rec['LAST_INSERT_ID()'];

            for ($i=0; $i < $max; $i++) {
                $sql='INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES(?,?,?,?)';
                $stmt=$dbh->prepare($sql);
                $data=array();
                $data[]=$lastcode;
                $data[]=$cart[$i];
                $data[]=$kakaku[$i];
                $data[]=$kazu[$i];
                $stmt->execute($data);
            }

            $sql = 'UNLOCK TABLES';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $dbh=null;

            $honbun.="送料は無料です。\n";
            $honbun.="--------------------\n";
            $honbun.="代金は以下の口座にお振込みください。\n";
            $honbun.="○○銀行　△△支店　普通口座　1234567 \n";
            $honbun.="入金の確認が取れ次第、発送させていただきます。\n";
            $honbun.="\n";
            $honbun.="********************\n";
            $honbun.="～会社名～\n";
            $honbun.="\n";
            $honbun.="AAA県BBB市CCC 123-4\n";
            $honbun.="電話番号　090-xxxx-yyyy\n";
            $honbun.="メールアドレス　abcdefg@vwxyz.co.jp\n";
            $honbun.="********************\n";
            //内容確認用
            //'<br>';
            //echo nl2br($honbun);

            $title='ご注文ありがとうございます。';
            $header='From: abcdefg@vwxyz.co.jp';
            $honbun=html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail($email, $title, $honbun, $header);

            $title='お客様からご注文がありました。';
            $header='From: '.$email;
            $honbun=html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail('abcdefg@vwxyz.co.jp', $title, $honbun, $header);
        }
        catch (Exception $e) {
            echo 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
        
        $_SESSION=array();
        session_destroy();
    ?>
    <br>
    <a href="shop_list.php">商品画面へ</a>
</body>
</html>