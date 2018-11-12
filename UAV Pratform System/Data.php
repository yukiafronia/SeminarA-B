<?php
// セッション開始
session_start();

$db['host'] = "202.48.48.101";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "Yukiafronia1102"; // ユーザー名のパスワード
$db['dbname'] = "userData";  // データベース名

$UserName = $_SESSION["NAME"];
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Google Maps APIの読み込み -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBboi4Xm_7zQ9kOZtCeuT-tMG-Q5HR9YLY&sensor=false&libraries=geometry"></script>
    <title>Setting</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
    <link href="css/style02.css" rel="stylesheet">
    <style>
        #map-canvas{
        	width:900px;
        	height:450px;
        	float:center;
        }

        #gps{
        	font-size:12px;
        	width:250px;
        	height:300px;
        }
        #dist{
        	border:1px solid #ccc;
        	width:400px;
        	margin-top:20px;
        }
        #dist th{
        	background-color:#e0e0e0;
        	/*border:1px solid #ccc; */
        	text-align:center;
        	width:400px;
        }
        #dist td{
        	border:1px solid #ccc;
        	text-align:center;
        	width:450px;
        	height:40px;
        }
        #ex{
        	font-size:12px;
        	width:240px;
        	border:1px solid #cccccc;
        	padding:5px;
        	background-color:#f0f0f0;
        }
        </style>
        <script>
          function load() {
            alert("load イベントが発生しました。");
          }
          window.onload = load;
          </script>
          <script type="text/javascript">
              var KK,AX,AY,BX,BY,CX,CY,DX,DY,AB_kyori,CD_kyori,kyori_h,hiritsu,ABX_h,ABY_h,CDX_h,CDY_h,AB_k,CD_k;
              <!--座標を入力（DBから取得できるようにする予定）-->
              AX = 35.369566;
              AY = 139.416746;
              BX = 35.370953;
              BY = 139.416907;
              CX = 35.369529;
              CY = 139.41531;
              DX = 35.371196;
              DY = 139.415712;
              <!--飛行間隔を変数に格納（ページ上で変更できるようにする予定）-->
              KK = 8;
              //var myRootJ = JSON.stringify(myRoot);
              //console.log(myRootJ);
              /*
              <!--テスト用にいろいろ出力-->
              console.log(kyori_h);
              console.log(AB_kyori);
              console.log(CD_kyori);
              console.log(hiritsu);
              console.log(AB_k);
              console.log(CD_k);
              console.log(ABX_h);
              console.log(ABY_h);
              console.log(CDX_h);
              console.log(CDY_h);
              console.log(aryABX);
              console.log(aryABY);
              console.log(aryCDX);
              console.log(aryCDY);
              console.log(aryAB);
              console.log(aryCD);
              */
              var poly;
              var map;
              var cnt=0;
              var marker;
              var path;
              $(function(){
              	initialize();
              	$("#run").click(function(){
              		dist_calc();
              	});
              	$("#reset").click(function(){
              		reset();
              	});
              });
              function initialize() {
                var shiroi = new google.maps.LatLng(35.3309774, 139.4058813);
                var myOptions = {
                  zoom: 15,
                  center: shiroi,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  draggableCursor: "default"
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
              }
              function dist_calc(){
              	//2重で描画されないようにリセットする
                  if (poly) {
                    poly.setMap(null);
                  }
                  $("#gps").val('');
                  $('#ruler').text("0");
                  $('#ruler1').text("0");
              	KK=document.js.txtb.value;
              	<!--入力された座標から距離を計算-->
              AB_kyori = Math.sqrt((BX-AX)*(BX-AX)+(BY-AY)*(BY-AY))*100000;
              CD_kyori = Math.sqrt((DX-CX)*(DX-CX)+(DY-CY)*(DY-CY))*100000;
              <!--ABの距離に対するCDの距離の比率を計算-->
              hiritsu = CD_kyori / AB_kyori;
              <!--ABとCDの角度を計算-->
              AB_k = Math.atan2(BX-AX,BY-AY);
              CD_k = Math.atan2(DX-CX,DY-CY);
              <!--10mあたりの座標の変動値を計算-->
              ABX_h = Math.sin(AB_k)/(100000/KK);
              ABY_h = Math.cos(AB_k)/(100000/KK);
              CDX_h = Math.sin(CD_k)/(100000/KK)*hiritsu;
              CDY_h = Math.cos(CD_k)/(100000/KK)*hiritsu;
              <!--距離から配列の数を計算-->
              kyori_h = Math.ceil(AB_kyori / KK);
              <!--配列を作成-->
              var aryABX = new Array(kyori_h);
              var aryABY = new Array(kyori_h);
              var aryCDX = new Array(kyori_h);
              var aryCDY = new Array(kyori_h);
              var aryAB = new Array(kyori_h);
              var aryCD = new Array(kyori_h);
              <!--配列の0番目に始点の座標を追加-->
              var i = 1;　//配列用の変数
              <!--始点を配列に追加-->
              aryABX[0] = AX;
              aryABY[0] = AY;
              aryCDX[0] = CX;
              aryCDY[0] = CY;
              <!--配列に10mごとの座標を追加-->
              while(i <= kyori_h){
              	aryABX[i] = aryABX[i-1]+ABX_h; //一つ前の配列の座標に変動値を追加
              	aryABY[i] = aryABY[i-1]+ABY_h;
              	aryCDX[i] = aryCDX[i-1]+CDX_h;;
              	aryCDY[i] = aryCDY[i-1]+CDY_h;;
              	//alert(i);
              	//ルートが範囲外にならないように超えた場合は強制的に座標を書き換える
              	if(aryABX[i] > BX)aryABX[i] = BX;
              	if(aryABY[i] > BY)aryABY[i] = BY;
              	if(aryCDX[i] > DX)aryCDX[i] = DX;
              	if(aryCDY[i] > DY)aryCDY[i] = DY;
              	i++;
              }
              for (var i = 0; i <= kyori_h; i++) {
              	eval("var ABX" + i + "=" + aryABX[i] + ";");
              	eval("var ABY" + i + "=" + aryABY[i] + ";");
              	eval("var CDX" + i + "=" + aryCDX[i] + ";");
              	eval("var CDY" + i + "=" + aryCDY[i] + ";");
              }
              //xとyを1つの配列に統合する
              i = 1;
              for(var i = 0; i <= kyori_h; i++){
              	aryAB[i] = aryABX[i] + ',' + aryABY[i];
              	aryCD[i] = aryCDX[i] + ',' + aryCDY[i];
              }
              //ABとCDそれぞれの座標を並び替えてルートを1つの配列に作成する
              var rimit = (kyori_h * 2);
              console.log(rimit);
              var x = 1;
              var abr = 0;
              var cdr = 1;
              var myRoot = new Array(rimit);
              for(var i = 0; i <= rimit; i++){
              	if(x == 1){
              		myRoot[i] = aryAB[abr];
              		abr++;
              		i++;
              		if(i > rimit)break;
              		myRoot[i] = aryAB[abr];
              		abr++;
              	}
              	if(x == -1){
              		myRoot[i] = aryCD[cdr];
              		cdr++;
              		i++;
              		if(i > rimit)break;
              		myRoot[i] = aryCD[cdr];
              		cdr++;
              	}
              	x = x * -1
              }
                var polyOptions = {
                  strokeColor: '#FF3333',
                  strokeOpacity: 0.8,
                  strokeWeight: 3
                }
                poly = new google.maps.Polyline(polyOptions);
                poly.setMap(map);
              /*
                	//配列に入力欄の座標を挿入？
              	var gpsStr  = $("#gps").val();
              	console.log(gpsStr);
              	//改行で分けている？
              	var gpsArry = gpsStr.split("\n");
              	console.log(gpsArry);
              	//flen = gpsArry.length;
              	flen = aryAB.length;
              */
              	//最終データが改行で終了している場合を考慮しundefinedか否かを判定する
              	var len = 0;
              	for(var i=0; i < myRoot.length; i++){
              		if((typeof myRoot[i] === "undefined") || (myRoot[i] === "")){
              			break;
              		}else{
              			len ++;
              		}
              	}
              	path = poly.getPath();
              	var bounds = new google.maps.LatLngBounds();
              	var latLngArry = [];
              	for(var i=0; i < len; i++){
              		var wLatLng = new google.maps.LatLng(myRoot[i].split(",")[0], myRoot[i].split(",")[1]);
              		path.push(wLatLng);
              		bounds.extend(wLatLng);
              		latLngArry[i] = wLatLng;
              	}
              	console.log(bounds);
              	console.log(wLatLng);
              	map.fitBounds(bounds);
              	// Googleの関数を使用した距離計算
              	//var dist = 0;
              	/*
              	for(var i=1; i < len; i++){
              		dist += google.maps.geometry.spherical.computeDistanceBetween(latLngArry[i - 1], latLngArry[i]);
              	}
              	*/
              	var dist = google.maps.geometry.spherical.computeLength(path);
              	dist = Math.round(dist)/1000.0
              	$("#ruler").text(dist);
              	$("#ruler1").text(KK);
              }
                // Clear all overlays, reset the array of points, and hide the chart
                function reset() {
                  if (poly) {
                    poly.setMap(null);
                  }
                  $("#gps").val('');
                  $('#ruler').text("0");
                  $('#ruler1').text("0");
                }
              /*ダウンロード用のコード。有効にしたい場合はファイルの拡張子をPHPにする
                $(function(){
                $('.btn').on('click',function(){
                  // 配列 の用意
                  var array_data = [['りんご',1,200],['メロン',2,4000],['バナナ',4,500]];
                  // BOM の用意（文字化け対策）
                  var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
                  // CSV データの用意!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                  var csv_data = array_data.map(function(l){return l.join(',')}).join('\r\n');
                  var blob = new Blob([bom, csv_data], { type: 'text/csv' });
                  var url = (window.URL || window.webkitURL).createObjectURL(blob);
                  var a = document.getElementById('downloader');
                  a.download = 'data.csv';
                  a.href = url;
                  // ダウンロードリンクをクリックする
                  $('#downloader')[0].click();
                });
              });
              */
              //テキストボックスの文字を操作する
              function clr(){
                document.js.txtb.value="";
              }
              </script>
    </head>
    <body id="Setting" onload="initialize()">
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
            <div id="container">
              <div id="map-canvas"></div>
              <div id="menu">
            <!--<p>
            距離：<input type="text" id="dist" value="" size="12" style="text-align: right;">&nbsp;Km
            </p>-->
            <table id="dist">
            	<tr>
            		<th>総飛行距離</th>
            		<!--<th>時間</th>-->
                <td><span style="font-size:20px;font-weight:bold;" id="ruler">0</span>km</td>
            		<!--<td><span style="font-size:20px;font-weight:bold;" id="time">0</span>時間</td>-->
            	</tr>
            	<tr>
            		<th>飛行間隔</th>
            		<!--<th>時間</th>-->
                <td><span style="font-size:18px;font-weight:bold;" id="ruler1">0</span>m</td>
            		<!--<td><span style="font-size:20px;font-weight:bold;" id="time">0</span>時間</td>-->
            	</tr>
            </table>
            <br>
            <form name="js">
            <p>飛行間隔：<input type="text" name="txtb" value="">&nbsp;&nbsp;
            <input type="button" id="run"   value="描画"/>&nbsp;&nbsp;
              <input type="button" id="reset"   value="リセット"/></p>
            <!--<input type="button" value="消去" onclick="clr()"><br>-->
            </form>

            </div>
            </div>
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
