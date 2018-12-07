<?php
require_once("util.php");
$user = 'root';
$password = 'Yukiafronia1102';
$dbName = 'userData';
$host　= '202.48.48.101';
$dsn = "mysql:host=202.48.48.101;dbname=userData;charset=utf8";
?>
<!DOCTYPE html>
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
                    <li><a href="form.php">Form</a></li>
                    <li><a href="logout.php">Log off</a></li>
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

                      $sql = "SELECT * FROM user";
                      $stm = $pdo->prepare($sql);
                      // SQL文を実行する
                      $stm->execute();
                      // 結果の取得（連想配列で返す）
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        echo "<table bgcolor='#ffffff' border='1'>";
                        echo "<thead><tr width='500',height='20'>";
                        echo "<th width='50'cellspacing='0'bgcolor='#cccccc'>", "ID", "</th>";
                        echo "<th width='125'cellspacing='0'bgcolor='#cccccc'>", "名前", "</th>";
                        echo "<th width='125'cellspacing='0'bgcolor='#cccccc'>", "TEL", "</th>";
                        echo "<th width='250'cellspacing='0'bgcolor='#cccccc'>", "メールアドレス", "</th>";
                        echo "<th width='250'cellspacing='0'bgcolor='#cccccc'>", "住所", "</th>";
                        echo "</tr></thead>";
                        // 値を取り出して行に表示する
                        echo "<tbody>";
                        foreach ($result as $row){
                          // １行ずつテーブルに入れる
                          echo "<tr>";
                          echo "<td><center>", es($row['id']), "</center></td>";
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
                </div>
                <br>
                <h2 class="icon">ユーザの追加</h2>
                <div class="form02">
                  <form method="POST" action="insert_member.php">
                    <dl>
                      <dt>
                        <label>名前：
                        <input type="text" name="name" placeholder="名前">
                        </label>
                      </dt>
                      <dt>
                        <label>メールアドレス：
                        <input type="text" name="email" placeholder="メールアドレス">
                        </label>
                      </dt>
                      <dt>
                        <label>電話番号：
                        <input type="number" name="tel" placeholder="半角数字">
                        </label>
                      </dt>
                      <dt>
                        <label>住所：
                        <input type="text" name="Location" placeholder="住所">
                        </label>
                      </dt>
                      <dt>
                        <label>パスワード：
                        <input type="text" name="password" placeholder="パスワード">
                        </label>
                      </dt>
                      <input type="submit" value="追加する">
                    </dl>
                  </form>
                </div>

              </section>
              </div>
              </div>
          </div>
        </div>
        <footer>
            <small>(C)2018 Ikebe-studio</small>
        </footer>
    </body>
</html>
