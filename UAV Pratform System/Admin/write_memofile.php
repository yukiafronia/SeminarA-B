<?php
// POSTされたテキスト文を取り出す
if (empty($_POST["memo"])){
  // POSTされた値がないとき（0の場合も含む）
  // リダイレクト（メモ入力ページへ戻る）
  $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
  header("HTTP/1.1 303 See Other");
  header('Location::http://202.48.48.101/Admin/Login2.php');
  exit();
}
// ファイルに書き込むストリングを作る
$memo = $_POST["memo"];
$date = date("Y/n/j G:i:s", time());
$newdata = $date . "　　" . $memo;
try {
  // ワークファイルのファイルオブジェクト（新規書き込み）
  $workingfileObj = new SplFileObject("working.tmp", "wb");
  // 新しいメモをワークファイルに書き込む
  $workingfileObj->flock(LOCK_EX);
  $workingfileObj->fwrite($newdata);
  $workingfileObj->flock(LOCK_UN);
} catch (Exception $e) {
  echo '<span class="error">エラーがありました。</span><br>';
  echo $e->getMessage();
  exit();
}

// 元ファイル
$filename = "memo.txt";
// 元ファイルがあるかどうか確認する
if (file_exists($filename)){
  // 元ファイルのファイルオブジェクト（読み込み専用モード）
  $fileObj = new SplFileObject($filename, "rb");
  // 元データを読み込む
  $fileObj->flock(LOCK_SH);
  $olddata = $fileObj->fread($fileObj->getSize());
  $fileObj->flock(LOCK_UN);

  // 古いデータを作業ファイルに追記する
  $olddata = "\n". $olddata;
  $workingfileObj->flock(LOCK_EX);
  $workingfileObj->fwrite($olddata);
  $workingfileObj->flock(LOCK_UN);

  // 元ファイルを閉じる
  $fileObj = NULL;
  // 元ファイルを削除する
  unlink($filename);
}

// 作業ファイルをクローズする
$workingfileObj = NULL;
// 作業ファイルをリネームする
rename("working.tmp", $filename);

// リダイレクト（メモを読むページへ）
$url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
header("HTTP/1.1 303 See Other");
header("Location:" . $url . "/Login2.php");
// ?>
