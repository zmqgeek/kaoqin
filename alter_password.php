<!doctype html> 
<html> 
<head> 
<meta charset="UTF-8"> 
<title>正在修改密码</title> 
</head> 
<body> 
  <?php
  session_start (); 
  $username = $_REQUEST ["username"]; 
  $oldpassword = $_REQUEST ["oldpassword"]; 
  $newpassword = $_REQUEST ["newpassword"]; 
    
  $con =new mysqli( "localhost", "root", "123456","FRT"); 
  if (! $con) { 
    die ( '数据库连接失败' . $mysqli_error () ); 
  } 
  $dbusername = null; 
  $dbpassword = null; 
  $result = $con->query ( "select * from user_info where username ='{$username}' and isdelete =0;" ); 
  while ( $row = mysqli_fetch_array ( $result ) ) { 
    $dbusername = $row ["username"]; 
    $dbpassword = $row ["password"]; 
  } 
  if (is_null ( $dbusername )) { 
    ?> 
  <script type="text/javascript"> 
    alert("用户名不存在"); 
    window.location.href="alter_password.html"; 
  </script>  
  <?php
  } 
  if ($oldpassword != $dbpassword) { 
    ?> 
  <script type="text/javascript"> 
    alert("密码错误"); 
    window.location.href="alter_password.html"; 
  </script> 
  <?php
  } 
  $con->query ( "update user_info set password='{$newpassword}' where username='{$username}'" ) or die ( "存入数据库失败" . mysqli_error () );//如果上述用户名密码判定不错，则update进数据库中 
  mysqli_close ( $con ); 
  ?> 
  
  
  <script type="text/javascript"> 
    alert("密码修改成功"); 
    window.location.href="index.html"; 
  </script> 
</body> 
</html> 
