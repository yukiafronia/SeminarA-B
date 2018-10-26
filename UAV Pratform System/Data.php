<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "toor";  // ユーザー名のパスワード
$db['dbname'] = "userData";  // データベース名

$UserName = $_SESSION["email"];
 //ユーザーメールアドレス
// ログイン状態チェック
//if (!isset($_SESSION["NAME"])) {
$errorMessage = "";
$signUpMessage = "";
//変数の初期化
  $sql = null;
  $pdo = null;
  $res = null;
  $dsn = null;

  //header("ocation: logout.php");
    //echo ("SQL文を実行します");

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["renraku"])) {  // 値が空のとき
        $errorMessage = '希望の連絡先が未入力です。';
    } else if (empty($_POST["syurui"])) {
        $errorMessage = '作物種別が未入力です';
    } else if (empty($_POST["year"])) {
          $errorMessage = '希望の年を選択してください。';
    } else if (empty($_POST["month"])) {
          $errorMessage = '希望の月を選択してください。';

    } else if (empty($_POST["day"])) {
    $errorMessage = '希望の日を選択してください。';
    }else if (empty($_POST["time"])) {
        $errorMessage = '希望の時間を選択してください。';
    }

    if (!empty($_POST["renraku"]) &&!empty($_POST["syurui"]) && !empty($_POST["year"]) && !empty($_POST["month"]) && !empty($_POST["day"])&& !empty($_POST["time"])) {
        // 入力したユーザIDとパスワードを格納
        //$userid = $_SESSION["id"];
        $renraku = $_POST["renraku"];
	      $syurui = $_POST["syurui"];
	      $year = $_POST["year"];
	      $month = $_POST["month"];
        $day = $_POST["day"];
        $time = $_POST["time"];
        $ts = time();


        // 3. エラー処理
        try {
            $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            //$sql = sprintf("SELECT * FROM `user` WHERE `name` LIKE '$UserName'");
            //$res = $pdo->query($sql);
            $stmt = $pdo->prepare("INSERT INTO sub (userid, renraku, syurui, year, month, day, time, ts) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute(array($UserName, $renraku, $syurui, $year, $month,  $day, $time, $ts));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $id = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage = '登録が完了しました。あなたの予約IDは '. $id. ' です。希望日時は '. $year.'年'.$month.'月'.$day.'日'.$time. 'です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
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
                    <li><a href="Login1.php">Data</a></li>
                    <li><a href="Setting.php">Setting</a></li>
                    <li><a href="logout.php">Log off</a></li>
                </ul>
            </nav>
        </header>

        <div id="wrap">
          <div class="content">
            <div class="main-center">
            <h1>Data</h1>
            <h2 class="icon">ルート作成・確認</h2>
            <div class="form02">
              <p>aaaaa</p>
            </div>
            <hr>
            <h2 class="icon">予約申請</h2>
            <div class="form03">
              	<form id="loginForm" name="loginForm" action="" method="POST">
                  <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                  <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

              <dl>
                <dt>ご希望のご連絡方法</dt>
                <dd>
                  <select name="renraku" class="type">
                    <option value="0"></option>
                    <option>お電話</option>
                    <option>メール</option>
                  </select>
                </dd>
                <dt>作物種別</dt>
                <dd>
                  <select name="syurui" class="type">
                    <option value="0"></option>
                    <option>畑（葉物野菜など）</option>
                    <option>水田（穀物類など）</option>
                    <option>樹木（果樹など）</option>
                    <option>建物（牛舎・鶏舎など）</option>
                  </select>
                </dd>
            <dt>ご希望日時</dt>
            <dd>
                <select name="year" id="year">
                  <option value="0"></option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  <option value="2027">2027</option>
                  <option value="2028">2028</option>
                  </select>年
                <select name="month" id="month">
                    <option value="0"></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>月
                    <select name="day"id="day">
                    <option value="0"></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>日
                <select name="time"id="time">
                  　<option value="0"></option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                  </select>時から
            </dd>
            </dl>
              <input type="submit" id="signUp" name="signUp" value="予約">
              <br>
            </form>
            </div>
            <hr>

          </div>
              </div>
          </div>
        </div>
        <footer>
            <small>(C)2018 Ikebe-studio</small>
        </footer>
    </body>
</html>
