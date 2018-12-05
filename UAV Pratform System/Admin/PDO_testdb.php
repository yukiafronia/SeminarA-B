<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>PDOでデータベースに接続する</title>

</head>
<body>
<div>
  <?php
  // データベースユーザ
  $user = 'root';
  $password = 'Yukiafronia1102';
  $dbName = 'userData';
  $host　= '202.48.48.101';
  $dsn = "mysql:host=202.48.48.101;dbname=userData;charset=utf8";

  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "データベース{$dbName}に接続しました。";
    // 接続を解除する
    $pdo = NULL;
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
    exit();
  }
  ?>
</div>
</body>
</html>
