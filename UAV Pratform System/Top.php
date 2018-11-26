<?php
require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "202.48.48.101";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "Yukiafronia1102";  // ユーザー名のパスワード
$db['dbname'] = "userData";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['id'];
                    $sql = "SELECT * FROM user WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['email'];  // ユーザー名
                    }
                    $id = $row['id'];
                    $sql = "SELECT * FROM user WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];
                    }
                    $_SESSION["NAME"] = $row['name'];
                    $_SESSION["Email"] = $row['email'];
                    $_SESSION["id"] = $row['id'];
                    header("Location: Login1.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            $errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
             echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>TopPage</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
    <link href="css/style01.css" rel="stylesheet">
    </head>
    <body id="index">
        <header>
            <div class="logo">
                <!--ここにロゴ入れたい-->
            </div>
            <nav>
                <ul class="global-nav">
                    <li><a href="Top.php">Home</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="Contact.html">Contact</a></li>
                </ul>
            </nav>
        </header>
        <div id="wrap">
        <div class="content">
          <h1>ドローンによる鳥類対策支援システム<br>開発プロジェクト</h1>
          <p>このWebサイトは、地方自治体における鳥類による農作物被害を少しでも抑えようと思い、開発したサイトです。<br>
            学生たちが考えたドローンを使用した農地を網羅する為のルートを作成し、ドローンを飛行させます。<br>
            そのための農地データの管理や飛行記録などを残しておくためのサイトです。</p>
          <div id="form">
	    <form id="loginForm" name="loginForm" action="" method="POST">

                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="userid"><br></label><input type="userid" id="userid" name="userid" placeholder="メールアドレスを入力" value=""size="60">
                <br>
                <label for="password"><br></label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br><br>
                <input type="submit" id="login" name="login" value="Login">
                <br>
                <center><u><p><a href="Newuser1.php"class="linkB">新規登録はこちらから</a></p></u></center>

  </form>

          </div>
        </div>
        <footer>
            <small>(C)2018 Ikebe-studio</small>
        </footer>
    </body>
</html>
