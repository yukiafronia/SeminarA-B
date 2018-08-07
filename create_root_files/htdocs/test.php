<?php
$user = "root";
$pass = "root";
$dbh =new PDO('mysql:host=localhost;dbname=latlng;charset=utf8', $user, $pass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM farmer_data";
$stmt = $dbh->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($result);
$dbh = null;


require('dbconnect.php');
$recordset = mysql_query('select * from farmer_data'); 
$data = mysql_fetch_assoc($recordset); 
echo $data['id']; 
?>

<html> 
・ 
・ 
・ 
<body>

<table width="80%" border="1"> 
 <tr> 
  <th scope="col">ID</th> 
  <th scope="col">名前</th> 
  <th scope="col">住所</th> 
  <th scope="col">面積</th> 
  <th scope="col">電話番号</th>
  <th scope="col">作物コード</th>
  <th scope="col">収穫開始</th>
  <th scope="col">収穫終了</th>
 </tr> 
 <?php 
 while($table = mysql_fetch_assoc($recordset)) { 
 ?> 
 <tr> 
  <td><?php print(htmlspecialchars($table['id'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['name'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['address'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['area'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['tell'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['corps_code'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['harvest_start'])); ?> </td> 
  <td><?php print(htmlspecialchars($table['harvest_end'])); ?> </td> 
 </tr> 
 <?php 
 } 
 ?> 
 </table> 
</body> 
</html>