<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
    echo "hello world";
    $con=new mysqli("localhost","root","123456","FRT"); 
    if (!$con) { 
      die('数据库连接失败'.$mysql_error()); 
    }
    $con->query("insert into user_info (id,username,password) values('1','123','456')") or die("存入数据库失败".mysql_error()) ; 
    mysqli_close($con); 
?>
<body>
</html>

