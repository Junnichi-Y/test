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
    $pro_name=$post['name'];
    $pro_price=$post['price'];
    $pro_gazou=$_FILES['gazou'];
    
    if($pro_name==''){
        echo '商品名が入力されていません。<br>';
    }
    else{
        echo '商品名：';
        echo $pro_name;
        echo '<br>';
    }
    if(preg_match('/\A[0-9]+\z/',$pro_price)==0){
        echo '価格をきちんと入力してください。<br>';
    }
    else{
        echo '価格：';
        echo $pro_price;
        echo '円 <br>';
    }
    if($pro_gazou['size']>0){
        if ($pro_gazou['size']>1000000) {
            画像が大きすぎます。;
        }
        else{
            move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
            echo '<img src="./gazou/'.$pro_gazou['name'].'">';
            echo '<br>';
        }
    }
    if($pro_name=='' || preg_match('/\A[0-9]+\z/',$pro_price)==0 || $pro_gazou['size']>1000000){
        echo'<from>';
        echo'<input type="button" onclick="history.back()" value="戻る">';
        echo '</from>';
    }
    else{
        echo '上記の商品を追加します。<br>';
        echo '<form method="post" action="pro_add_done.php">';
        echo '<input type="hidden" name="name" value="'.$pro_name.'">';
        echo '<input type="hidden" name="price" value="'.$pro_price.'">'.'<br>';
        echo '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        echo '<input type="submit" value="OK">';
        echo '</form>';
    }
    ?>
</body>
</html>