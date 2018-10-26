<?php
session_start();

if (isset($_SESSION["NAME"])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
    <title>LogOff</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet"> 
    <link href="css/style01.css" rel="stylesheet">
    </head>
<body id="index">
        <header>
            <div class="logo">
                <!--ここにロゴ入れたい-->
            </div>
        </header>
        <div id="wrap">
        <div class="content">
          <center><h1><div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div></h1></center>
         </div>
	<center><u><h2><a href="top.php">ログイン画面に戻る</a><h2></u></center>

	<footer>
            <small>(C)2018 Ikebe-studio</small>
        </footer>
    </body>
</html>
