<?php
require_once("util.php");
$gobackURL = "Data2.php";

// 文字エンコードの検証

// データベースユーザ
$user = 'root';
$password = 'Yukiafronia1102';
$dbName = 'userData';
$host　= '202.48.48.101';
$dsn = "mysql:host=202.48.48.101;dbname=userData;charset=utf8";
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
