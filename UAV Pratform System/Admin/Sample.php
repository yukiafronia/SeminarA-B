<?php
require_once("util.php");
$user = 'root';
$password = 'toor';
$dbName = 'userData';
$host　= 'localhost';
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
?>
?<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Login02</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
    <link href="css/style02.css" rel="stylesheet">
    </head>
    <body id="login01">
        <header>
            <div class="logo">
                <!--ここにロゴ入れたい-->
            </div>
            <nav>
                <ul class="global-nav">
                    <li><a href="Login2.php">Data</a></li>
                    <li><a href="Setting.html">Setting</a></li>
                    <li><a href="Top.html">Log off</a></li>
                </ul>
            </nav>
        </header>
        <div id="wrap">
          <div class="content">
            <div class="main-center">
              <section>
              <h1>管理者ページ</h1>
              <h2 class="icon">登録者一覧</h2>
                <div class="form02">
                <br>
                <div style="overflow: scroll; height: 20em;">
                  <?php
                  try{
                    $pdo = new PDO($dsn,$user,$password);
                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    echo "データベース{$dbName}に接続しました。";
                      $sql = "SELECT * FROM user";
                      $stm = $pdo->prepare($sql);
                      // SQL文を実行する
                      $stm->execute();
                      // 結果の取得（連想配列で返す）
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        echo "<table>";
                        echo "<thead><tr>";
                        echo "<th>", "ID", "</th>";
                        echo "<th>", "名前", "</th>";
                        echo "<th>", "TEL", "</th>";
                        echo "<th>", "メールアドレス", "</th>";
                        echo "<th>", "住所", "</th>";
                        echo "</tr></thead>";
                        // 値を取り出して行に表示する
                        echo "<tbody>";
                        foreach ($result as $row){
                          // １行ずつテーブルに入れる
                          echo "<tr>";
                          echo "<td>", es($row['id']), "</td>";
                          echo "<td>", es($row['name']), "</td>";
                          echo "<td>", es($row['tel']), "</td>";
                          echo "<td>", es($row['email']), "</td>";
                          echo "<td>", es($row['Location']), "</td>";
                          echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                  }catch(Exception $e){
                    echo '<span class="error">エラーがありました。</span><br>';
                    echo $e->getMessage();
                    exit();
                  }
                  ?>
                </div>
                <br>
                </div>
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
