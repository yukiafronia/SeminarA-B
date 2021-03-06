<html>
<head>
<title>自動ルート作成</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Google Maps APIの読み込み -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>
<style>
html,body{
	margin: 0;
	font-size:small;
	font-family:meiryo;
}
#map-canvas{
	width:79%;
	height:100%;
	float:left;
}
#menu{
	width:20%;
	height:100%;
	background-color:#ffffff;
	padding-left:10px;
	float:left;
}
#gps{
	font-size:12px;
	width:250px;
	height:300px;
}
#dist{
	border:1px solid #ccc;
	width:150px;
	margin-top:20px;
}
#dist th{ 
	background-color:#e0e0e0; 
	/*border:1px solid #ccc; */
	text-align:center; 
	width:146px;
}
#dist td{ 
	border:1px solid #ccc;
	text-align:center; 
	width:146px;
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

KK = 10;

<!--入力された座標から距離を計算-->
AB_kyori = Math.sqrt((BX-AX)*(BX-AX)+(BY-AY)*(BY-AY))*100000;
CD_kyori = Math.sqrt((DX-CX)*(DX-CX)+(DY-CY)*(DY-CY))*100000;

<!--ABの距離に対するCDの距離の比率を計算-->
hiritsu = CD_kyori / AB_kyori;

<!--ABとCDの角度を計算-->
AB_k = Math.atan2(BX-AX,BY-AY);
CD_k = Math.atan2(DX-CX,DY-CY);

<!--10mあたりの座標の変動値を計算-->
ABX_h = Math.sin(AB_k)/10000;
ABY_h = Math.cos(AB_k)/10000;
CDX_h = Math.sin(CD_k)/10000*hiritsu;
CDY_h = Math.cos(CD_k)/10000*hiritsu;

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




var myRootJ = JSON.stringify(myRoot);

console.log(myRootJ);


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
}
  // Clear all overlays, reset the array of points, and hide the chart
  function reset() {
    if (poly) {
      poly.setMap(null);
    }
    
    $("#gps").val('');
    $('#ruler').text("0");
  }






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






</script>





</head>
<body onload="initialize()">
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
	</tr>
	<tr>
		<td><span style="font-size:20px;font-weight:bold;" id="ruler">0</span>km</td>
		<!--<td><span style="font-size:20px;font-weight:bold;" id="time">0</span>時間</td>-->
	</tr>
</table>

<p><input type="button" id="run"   value="描画"/>
</p>
<p><input type="button" id="reset"   value="リセット"/>
</p>

</div>

</div>




<button type="button" name="aaa" value="aaa" class="btn">
	座標をエクスポート
</button>

<a style="display:none;" id="downloader" href="#"></a>


</body>
</html>