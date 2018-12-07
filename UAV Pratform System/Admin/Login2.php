<?php
require_once("util.php");
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
              <h2 class="icon">新着情報・通知</h2>
                <div class="form02">
                <form method="POST" action="write_memofile.php">
                <dl>
                  <dt>新着情報記入欄<hr></dt>
                  <dd><textarea name="memo" cols="80" rows="3" maxlength="100" placeholder="新着情報記入"></textarea>&emsp;
                  <button type="submit" class="btn">送信</button></dd><hr>
                </dl>
              </form>
                <br>
                <div style="overflow: scroll; height: 20em;">
                  <?php
                    $filename = "memo.txt";
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
                      echo "<hr>";
                      echo $readdata_br;"<hr>";
                    } else {
                      // ファイルエラー
                      echo '<span class="error">ファイルを読み込めませんでした。</span>';
                    }
                    ?>
                </div>
                </div>
                <br>
                <h2 class="icon">人口密集地データ</h2>
                <div class="form02">
                  <iframe src="https://www.google.com/maps/d/embed?mid=1_iNwo1KNa-CTy_RH8Vzput4aYSgX5Nyn&z=10" width="900" height="450"></iframe>
                </div>
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
