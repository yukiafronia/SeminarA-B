<?php

ini_set('mbstring.internal_encoding' , 'UTF-8');
// 「mysql:」の後に接続するデータベースを指定する。
$dsn = 'mysql:dbname=latlng;host=localhost';
$user = 'root';
$password = 'root';

try{
    $dbh = new PDO( $dsn, $user, $password );
}catch( PDOException $error ){
    // 接続に失敗した場合、エラーメッセージを表示。
    echo "接続失敗:".$error->getMessage();
    die();
}

// SQL文を変数「$sql」に代入。
$sql = "SELECT * FROM farmer_data";
// SQL文の実行結果を変数「$stmt」に代入。
$stmt = $dbh->query( $sql );

echo "<table>\n";

echo "\t
<tr>
	<th>id</th>
	<th>名前</th>
	<th>住所</th>
	<th>面積</th>
	<th>電話番号</th>
	<th>作物コード</th>
	<th>収穫開始</th>
	<th>収穫終了</th>
</tr>
\n";

// 「$stmt」からデータを取り出し、変数「$result」に代入。
// 「PDO::FETCH_ASSOC」を指定した場合、カラム名をキーとする連想配列として「$result」に格納される。
while( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ){
    echo "\t<tr>\n";
    echo "\t\t<td>{$result['id']}</td>\n";
    echo "\t\t<td>{$result['name']}</td>\n";
    echo "\t\t<td>{$result['address']}</td>\n";
    echo "\t\t<td>{$result['area']}</td>\n";
    echo "\t\t<td>{$result['tell']}</td>\n";
    echo "\t\t<td>{$result['corps_code']}</td>\n";
    echo "\t\t<td>{$result['harvest_start']}</td>\n";
    echo "\t\t<td>{$result['harvest_end']}</td>\n";
    echo "\t</tr>\n";
}

echo "</table>\n";

?>