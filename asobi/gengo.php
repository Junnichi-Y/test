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

        $seireki=$_POST['seireki'];

        $wareki=gengo($seireki);
        echo $wareki;

    ?>
</body>
</html>