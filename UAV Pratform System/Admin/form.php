<?php
require_once("util.php");
$user = 'root';
$password = 'Yukiafronia1102';
$dbName = 'userData';
$host　= '202.48.48.101';
$dsn = "mysql:host=202.48.48.101;dbname=userData;charset=utf8";
?>
﻿<!DOCTYPE html>
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
                    <li><a href="Data2.php">Data</a></li>
                    <li><a href="Login2.php">Form</a></li>
                    <li><a href="logout.php">Log off</a></li>
                </ul>
            </nav>
        </header>
        <div id="wrap">
          <div class="content">
            <div class="main-center">
              <section>
              <h1>問い合わせ一覧</h1>
              <h2 class="icon">予約内容一覧</h2>
                <div class="form02">
                <br>
                <div style="overflow: scroll; height: 20em;">
                  <?php
                  try{
                    $pdo = new PDO($dsn,$user,$password);
                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                      $sql = "SELECT * FROM sub";
                      $stm = $pdo->prepare($sql);
                      // SQL文を実行する
                      $stm->execute();
                      // 結果の取得（連想配列で返す）
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        echo "<table bgcolor='#ffffff' border='1'>";
                        echo "<thead><tr width='500',height='20'>";
                        echo "<th width='50'cellspacing='0'bgcolor='#cccccc'>", "ID", "</th>";
                        echo "<th width='125'cellspacing='0'bgcolor='#cccccc'>", "名前", "</th>";
                        echo "<th width='125'cellspacing='0'bgcolor='#cccccc'>", "種類", "</th>";
                        echo "<th width='80'cellspacing='0'bgcolor='#cccccc'>", "年", "</th>";
                        echo "<th width='60'cellspacing='0'bgcolor='#cccccc'>", "月", "</th>";
                        echo "<th width='60'cellspacing='0'bgcolor='#cccccc'>", "日", "</th>";
                        echo "<th width='80'cellspacing='0'bgcolor='#cccccc'>", "時間", "</th>";
                        echo "<th width='125'cellspacing='0'bgcolor='#cccccc'>", "連絡", "</th>";

                        echo "</tr></thead>";
                        // 値を取り出して行に表示する
                        echo "<tbody>";
                        foreach ($result as $row){
                          // １行ずつテーブルに入れる
                          echo "<tr>";
                          echo "<td><center>", es($row['id']), "</center></td>";
                          echo "<td>", es($row['userid']), "</td>";
                          echo "<td>", es($row['syurui']), "</td>";
                          echo "<td>", es($row['year']), "</td>";
                          echo "<td>", es($row['month']), "</td>";
                          echo "<td>", es($row['day']), "</td>";
                          echo "<td>", es($row['time']), "</td>";
                          echo "<td>", es($row['renraku']), "</td>";
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
                </div>
                <br>
                <h2 class="icon">コメント一覧</h2>
                  <div class="form02">
                  <br>
                  <div style="overflow: scroll; height: 20em;">
                    <?php
                    try{
                      $pdo = new PDO($dsn,$user,$password);
                      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
                      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                        $sql = "SELECT * FROM comment";
                        $stm = $pdo->prepare($sql);
                        // SQL文を実行する
                        $stm->execute();
                        // 結果の取得（連想配列で返す）
                          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                          echo "<table bgcolor='#ffffff' border='1'>";
                          echo "<thead><tr width='500',height='20'>";
                          echo "<th width='50'cellspacing='0'bgcolor='#cccccc'>", "ID", "</th>";
                          echo "</tr></thead>";
                          // 値を取り出して行に表示する
                          echo "<tbody>";
                          foreach ($result as $row){
                            // １行ずつテーブルに入れる
                            echo "<tr>";
                            echo "<td><center>", es($row['id']), "</center></td>";
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
