<?php
require_once("Admin/util.php");
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Top.php");


    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Login01</title>
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
                    <li><a href="Data.php">Data</a></li>
                    <li><a href="Setting.php">Setting</a></li>
                    <li><a href="logout.php">Log off</a></li>
                </ul>
            </nav>
        </header>
        <div id="wrap">
          <div class="content">
            <div class="main-center">
              <section>
              <h1><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>さんのページ</h1>
              <h2 class="icon">新着情報・通知</h2>
                <div class="form02">

                  <div style="overflow: scroll; height: 20em;">
                    <?php
                      $filename = "Admin/memo.txt";
                      try {
                        // ファイルオブジェクトを作る（rb 読み込み専用）
                        $fileObj = new SplFileObject($filename, "rb");
                      } catch (Exception $e) {
                        echo '<span class="error">エラーがありました。</span><br>';
                        echo $e->getMessage();
                        exit();
                      }

                      // ファイルロック（共有ロック）
                      $fileObj->flock(LOCK_SH);
                      // ストリングを読み込む
                      $readdata = $fileObj->fread($fileObj->getSize());
                      // アンロック
                      $fileObj->flock(LOCK_UN);

                      if (!($readdata === FALSE)){
                        // HTMLエスケープ（<br>を挿入する前に行う）
                        $readdata = es($readdata);
                        // 改行コードの前に<br>を挿入する
                        $readdata_br = nl2br($readdata, false);
                        echo "新着情報を読み込みました。", "<br>";
                        echo $readdata_br, "<hr>";

                      } else {
                        // ファイルエラー
                        echo '<span class="error">ファイルを読み込めませんでした。</span>';
                      }
                      ?>
                  </div>
                </div>
              <h2 class="icon">履歴</h2>
              <div class="form01">
              <form>
              <div style="overflow: scroll; height: 20em;">
              <table class="table01">
                  <tr>
                    <th class="day2">日付</th>
                    <th class="place">場所</th>
                    <th class="crops">作物名</th>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/01</td>
                    <td class="place">埼玉のどこか</td>
                    <td class="crops">ホウレン草</td>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/02</td>
                    <td class="place">茅ヶ崎のどこか</td>
                    <td class="crops">小松菜</td>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/03</td>
                    <td class="place">湘南大のどこか</td>
                    <td class="crops">ブロリー</td>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/04</td>
                    <td class="place">鎌倉のどこか</td>
                    <td class="crops">米</td>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/05</td>
                    <td class="place">川崎のどこか</td>
                    <td class="crops">麦</td>
                  </tr>
                  <tr>
                    <td class="day2">2018/09/06</td>
                    <td class="place">文教大学</td>
                    <td class="crops">トマト</td>
                  </tr>
               </table>
              </div>
              </form>
              <br>
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
