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

    $onamae=$post['onamae'];
    $email=$post['email'];
    $postal1=$post['postal1'];
    $postal2=$post['postal2'];
    $address=$post['address'];
    $tel=$post['tel'];

    $okflg=true;

    if ($onamae=='') {
        echo 'お名前が入力されていません。<br><br>';
        $okflg=false;
    }
    else {
        echo 'お名前<br>';
        echo $onamae.'<br><br>';
    }
    if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0) {
        echo 'メールアドレスが適切でありません。<br><br>';
        $okflg=false;
    }
    else {
        echo 'メールアドレス<br>';
        echo $email.'<br><br>';
    }
    if (preg_match('/\A[0-9]+\z/',$postal1)==0 || preg_match('/\A[0-9]+\z/',$postal2)==0) {
        echo '郵便番号は半角数字で入力してください。<br><br>';
        $okflg=false;
    }
    else {
        echo '郵便番号<br>';
        echo $postal1.'-'.$postal2.'<br><br>';
    }
    if ($address=='') {
        echo '住所が入力されていません。<br><br>';
        $okflg=false;
    }
    else {
        echo '住所<br>';
        echo $address.'<br><br>';
    }
    if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/',$tel)==0) {
        echo '電話番号を正確に入力してください。<br><br>';
        $okflg=false;
    }
    else {
        echo '電話番号<br>';
        echo $tel.'<br><br>';
    }

    if ($okflg==true) {
        echo '<form method="post" action="shop_form_done.php">';
        echo '<input type="hidden" name="onamae" value="'.$onamae.'">';
        echo '<input type="hidden" name="email" value="'.$email.'">';
        echo '<input type="hidden" name="postal1" value="'.$postal1.'">';
        echo '<input type="hidden" name="postal2" value="'.$postal2.'">';
        echo '<input type="hidden" name="address" value="'.$address.'">';
        echo '<input type="hidden" name="tel" value="'.$tel.'">';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        echo '<input type="submit" value="OK"><br>';
        echo '</form>';
    }
    else {
        echo '<form>';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        echo '</form>';
    }
    ?>
</body>
</html>