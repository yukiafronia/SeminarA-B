<!DOCTYPE html>
</div>
<html>
<head>
    <meta charset="utf-8"/>
    <title>新規登録</title>
    <link rel="stylesheet" type="text/css" href="css/style01.css"/>
</head>
<body>
<?php

session_start();

$sql = null;
$stm = null;
$dbh = null;

$name = $_REQUEST['name'];
$mail = $_REQUEST["mail"];
$tel = $_REQUEST['tel'];
$address = $_REQUEST['address'];
$id = $_REQUEST['id_user'];
$pw = $_REQUEST["password"];

$errorMessage = "";

$user = 'pi';
$password = 'rasraspberry';
$dsn = 'mysql:dbname=zemi_project;host=localhost';

try {

    $dbh = new PDO($dsn, $user, $password);
    //var_dump($dbh);
    echo 'データベース' . $dbn . 'に接続しました';

    $sql = "INSERT INTO `newuser` (`name`,`mail`,`tel`,`address`,`id`,`password`) VALUES ('$id','$pw','$adress')";
    $stm = $dbh->query($sql);
    // var_dump($stm);
    // echo 'mail: ' . $mail
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");


}catch (PDOException $e) {
    print('Error;' . $e->getMessage());
    die();
}

$dbh = null;

?>
<font color=black>
<div class="login">
    <h1>登録が完了しました。</h1>
    <form method="post" action="Newuser.html">
        <p>
            登録完了しました
            <input type="submit" value="戻る"/>
        </p>
    </form>
</div>
</font>
</body>
</html>
