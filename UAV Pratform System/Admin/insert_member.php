<?php
require_once("util.php");
$gobackURL = "Data2.php";

// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}
// 簡単なエラー処理
$errors = [];
if (!isset($_POST["name"])||($_POST["name"]==="")){
  $errors[] = "名前が空です。";
}
if (!isset($_POST["email"])||($_POST["email"]==="")){
  $errors[] = "メールアドレスが空です。";
}
if (!isset($_POST["tel"])||(!ctype_digit($_POST["tel"]))){
  $errors[] = "電話番号には数値を入れてください。";
}
if (!isset($_POST["Location"])||($_POST["Location"]==="")){
  $errors[] = "住所が空です。";
}
if (!isset($_POST["password"])||($_POST["password"]==="")){
  $errors[] = "パスワードが空です。";
}

//エラーがあったとき
if (count($errors)>0){
  echo '<ol class="error">';
  foreach ($errors as $value) {
    echo "<li>", $value , "</li>";
  }
  echo "</ol>";
  echo "<hr>";
  echo "<a href=", $gobackURL, ">戻る</a>";
  exit();
}
// データベースユーザ
$user = 'root';
$password = 'toor';
$dbName = 'userData';
$host　= 'localhost';
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>レコード追加</title>
<link href="css/style03.css" rel="stylesheet">
<link href="css/tablestyle.css" rel="stylesheet">
</head>
<body>
<div>
  <?php
  $name = $_POST["name"];
  $email = $_POST["email"];
  $tel = $_POST["tel"];
  $Location = $_POST["Location"];
  $pass = $_POST["password"];

  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文を作る
    $sql = "INSERT INTO user (name,email,tel,Location,password) VALUES (:name,:email,:tel,:Location,:password)";
    // プリペアドステートメントを作る
    $stm = $pdo->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':name', $name);
    $stm->bindValue(':email', $email);
    $stm->bindValue(':tel', $tel);
    $stm->bindValue(':Location',$Location);
    $stm->bindValue(':password',$pass);

    // SQL文を実行する
    if ($stm->execute()){
      // レコード追加後のレコードリストを取得する
      $sql = "SELECT * FROM user";
      // プリペアドステートメントを作る
      $stm = $pdo->prepare($sql);
      // SQL文を実行する
      $stm->execute();
      // 結果の取得（連想配列で受け取る）
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      // テーブルのタイトル行
      echo "<table>";
      echo "<thead><tr>";
      echo "<th>", "ID", "</th>";
      echo "<th>", "名前", "</th>";
      echo "<th>", "メールアドレス", "</th>";
      echo "<th>", "電話番号", "</th>";
      echo "<th>", "住所", "</th>";
      echo "<th>", "パスワード", "</th>";
      echo "</tr></thead>";
      // 値を取り出して行に表示する
      echo "<tbody>";
      foreach ($result as $row) {
        // １行ずつテーブルに入れる
        echo "<tr>";
        echo "<td>", es($row['id']), "</td>";
        echo "<td>", es($row['name']), "</td>";
        echo "<td>", es($row['email']), "</td>";
        echo "<td>", es($row['tel']), "</td>";
        echo "<td>", es($row['Location']), "</td>";
        echo "<td>", es($row['password']), "</td>";
        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
    } else {
      echo '<span class="error">追加エラーがありました。</span><br>';
    };
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>
