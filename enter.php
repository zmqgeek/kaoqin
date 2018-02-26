<!doctype html> 
<html> 
<head>
  <meta charset="UTF-8">  
  <title>登录系统的后台执行过程</title> 
</head> 
<body> 
  <?php
    session_start();//登录系统开启一个session内容 
    $username=$_REQUEST["username"];//获取html中的用户名（通过post请求） 
    $password=$_REQUEST["password"];//获取html中的密码（通过post请求） 
  
    $con=new mysqli("localhost","root","123456","FRT");//连接mysql 数据库，账户名root ，密码root 
    if (!$con) { 
      die('数据库连接失败'.$mysqli_error()); 
    }  
    $dbusername=null; 
    $dbpassword=null; 
    $result=$con->query("select * from user_info where username ='{$username}' and isdelete =0;");//查出对应用户名的信息，isdelete表示在数据库已被删除的内容 
    while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来 
      $dbusername=$row["username"]; 
      $dbpassword=$row["password"]; 
    } 
    if (is_null($dbusername)) {//用户名在数据库中不存在时跳回index.html界面 
  ?> 
  <script type="text/javascript"> 
    alert("用户名不存在"); 
    window.location.href="index.html"; 
  </script> 
  <?php 
    } 
    else { 
      if ($dbpassword!=$password){//当对应密码不对时跳回index.html界面 
  ?> 
  <script type="text/javascript"> 
    alert("密码错误"); 
    window.location.href="index.html"; 
  </script> 
  <?php 
      } 
      else { 
        $_SESSION["username"]=$username; 
        $_SESSION["code"]=mt_rand(0, 100000);//给session附一个随机值，防止用户直接通过调用界面访问welcome.php 
  ?> 
  <script type="text/javascript"> 
    window.location.href="login.html"; 
  </script> 
  <?php 
      } 
    } 
  mysqli_close($con);//关闭数据库连接，如不关闭，下次连接时会出错 
  ?> 
</body> 
</html> 
