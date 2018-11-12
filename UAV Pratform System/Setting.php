<?php

//echo ("セッションを開始します");
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "toor";  // ユーザー名のパスワード
$db['dbname'] = "userData";  // データベース名
$UserName = $_SESSION["NAME"];
$UserEmail = null; //ユーザーメールアドレス
$UserTel = null;
$UserLocation = null;
// ログイン状態チェック
//if (!isset($_SESSION["NAME"])) {

//変数の初期化
  $sql = null;
  $pdo = null;
  $res = null;
  $dsn = null;

    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
    $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    header("ocation: logout.php");
    //echo ("SQL文を実行します");
$sql = sprintf("SELECT * FROM `user` WHERE `name` LIKE '$UserName'");
$res = $pdo->query($sql);

foreach($res as $value){
//var_dump($value);
$UserEmail = $value["email"];
$UserTel = $value["tel"];
$UserLocation = $value["Location"];

}


//echo reset($res)['name'];

// if (!$result) {
//   print('クエリーが失敗しました。' . $mysqli->error);
//   echo ("開けませんでした");
//   $mysqli->close();
//     exit;
// }
//
// while ($row = $result->fetch_assoc()) {
//   $username = $row['name'];
//   $email = $row['email'];
// }
//exit;
//}
//  echo ("あなたの名前は".$_SESSION["NAME"]);
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Setting</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
    <link href="css/style02.css" rel="stylesheet">

    </head>
    <body id="Setting">
        <header>
            <div class="logo">
                <!--ここにロゴ入れたい-->
            </div>
            <nav>
               <ul class="global-nav">
                    <li><a href="Data.php">Data</a></li>
                    <li><a href="Login1.php">Setting</a></li>
                    <li><a href="logout.php">Log off</a></li>
                </ul>
            </nav>
        </header>
        <div id="wrap">
          <div class="content">
            <div class="main-center">
              <section>
		<h2 class="icon">個人情報確認</h2>
  		<div class="form03">
  			<dl>
  				<dt>お名前：</dt><dd><?php echo $UserName; ?></dd>
  				<dt>メールアドレス：</dt><dd><?php echo $UserEmail; ?></dd>
  				<dt>電話番号：</dt><dd><?php echo $UserTel; ?></dd>
  				<dt>住所：</dt><dd><?php echo $UserLocation; ?></dd>
  			</dl><br>
      </div>

                <h2 class="icon">情報変更</h2>
                <div class="form03">
                  <form>
                    <dl>
                      <dt><span class="required">お名前</span></dt>
                      <dd><input type="text"name="name"class="name"required></dd>
                      <dt><span class="required">メールアドレス</span></dt>
                      <dd><input type="email"name="email"class="email"required></dd>
                      <dt><span class="required">お電話番号</span></dt>
                      <dd><input type="tel"name="tel"class="tel"required></dd>
                      <dt><span class="required">住所</span></dt>
                      <dd><input type="Location"name="tel"class="Location"required></dd>
                      <dt><span class="required">パスワード</span></dt>
                      <dd><input type="password"name="password"class="password"required></dd>
                      <dt><span class="required">確認用パスワード</span></dt>
                      <dd><input type="password"name="password"class="password"required></dd>
                    </dl>
                    <button type="submit" class="btn">変更</button>
                  </form>
                </div>
              </section>

              </div>
          </div>
        </div>
        <footer>
            <small>(C)2018 Ikebe-studio</small>
        </footer>
    </body>
</html>
