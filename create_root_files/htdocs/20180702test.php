$dbname = 'latlng';        // データベース名
$host = 'localhost';        // ホスト
$user = 'root';         // mysqlに接続するユーザー
$password = 'root';    // パスワード
$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
    $dbh = new PDO($dns, $user, $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    if ($dbh == null) {
        print_r('接続失敗').PHP_EOL;
    } else {
        print_r('接続成功').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}