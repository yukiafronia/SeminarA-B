<?php
require 'password.php';   // password_hash()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "xampp";  // ユーザー名
$db['pass'] = "xampp_sqlserver";  // ユーザー名のパスワード
$db['dbname'] = "zemi_project";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";
$errorMessage_z = "";

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$Location = $_POST["Location"];

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["email"])) {
        $errorMessage = 'メールが未入力です。';
    } else if (empty($_POST["tel"])) {
        $errorMessage = '電話番号が未入力です。';
    } else if (empty($_POST["Location"])) {
        $errorMessage = '住所が未入力です。';
    }

    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE email = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_username);

        // Set parameters
        $param_email = trim($_POST["email"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // store result
            $stmt->store_result();

            if($stmt->num_rows == 1){
                $errorMessage = "This username is already taken.";
            } else{
                $email = trim($_POST["email"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

//    try{
//        $username = $_POST["username"];
//        $password = $_POST["password"];
//        $email = $_POST["email"];
//        $dsna = 'mysql:zemi_project;host=localhost;charset=utf8';
//        $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
//        $dbh = new PDO($dsna, $db['user'], $db['pass'], $option);
//
//        $sql = 'select count(*) as cnt from user where email=?';
//        $stmta = $dbh->prepare($sql);
//
//        $arrParam = array();
//        $arrParam[] = $email;
//        $stmta->execute($arrParam);
//
//        $row = $stmta->fetch(PDO::FETCH_ASSOC);
//        if (0 < $row['cnt']) {
//            $errorMessage_z = "{$email}は既に登録されています";
//        }
//
//    } catch (PDOException $e) {
//        $error = $e->getMessage();
//    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]&& !empty($_POST["email"])&& !empty($_POST["tel"])&& !empty($_POST["Location"])) {
        // 入力したユーザIDとパスワードを格納


        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO user (username,password,email,tel,Location) VALUES (?, ?, ?, ?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT),$email, $tel, $Location));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            //echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NewUser</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
    <link href="css/style01.css" rel="stylesheet">
</head>
<body id="about">
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
        <div class="main-center">
            <section>
                <h2 class="icon">新規登録</h2>
                <div class="form">
                    <form id="loginForm" name="loginForm" action="" method="POST">

                        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage_z, ENT_QUOTES); ?></font></div>

                        <table>
                            <tr>
                                <td><label for="username">ユーザー名</label></td>
                                <td><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="password">パスワード</label></td>
                                <td><input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></td>
                            </tr>
                            <tr>
                                <td><label for="password2">パスワード(確認用)</label></td>
                                <td><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力"></td>
                            </tr>
                            <tr>
                                <td><label for="email">メールアドレス</label></td>
                                <td><input type="text" id="email" name="email" value="" placeholder="メールアドレスを入力"></td>
                            </tr>
                            <tr>
                                <td><label for="tel">電話番号</label></td>
                                <td><input type="text" id="tel" name="tel" value="" placeholder="電話番号を入力"></td>
                            </tr>
                            <tr>
                                <td><label for="Location">住所</label></td>
                                <td><input type="text" id="Location" name="Location" value="" placeholder="住所を入力"></td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" id="signUp" name="signUp" value="新規登録">
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