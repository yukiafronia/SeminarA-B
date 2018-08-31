<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>アドレス登録</title>
</head>
<body>
<?php

$con = mysql_connect('192.168.11.4', 'pi', 'ras');
if (!$con) {
  exit('データベースに接続できませんでした。');
}

$result = mysql_select_db('phpdb', $con);
if (!$result) {
  exit('データベースを選択できませんでした。');
}

$result = mysql_query('SET NAMES utf8', $con);
if (!$result) {
  exit('文字コードを指定できませんでした。');
}

$name   = $_REQUEST['name'];
$mail = $_REQUEST['mail'];
$tel  = $_REQUEST['tel'];
$address = $_REQUEST['address'];
$id_user = $_REQUEST['id_user'];
$password = $_REQUEST['password'];
$password2 = $_REQUEST['password2'];
$id = $_REQUEST['id'];

$result = mysql_query("INSERT INTO address(name, mail, tel, address, id_user, password, password2, id) VALUES('$name', '$mail', '$tel', '$address', '$id_user', '$password', '$password2', '$id')", $con);
if (!$result) {
  exit('データを登録できませんでした。');
}

$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}

?>
<p>登録が完了しました。<br /><a href="index.html">戻る</a></p>
</body>
</html>