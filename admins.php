<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>

<table class="table table-hover">
	<caption>所有管理员信息</caption>
	<thead>
		<tr>
			<th>ID</th>
			<th>用户名</th>
			<th>权限</th>
		</tr>
	</thead>
	<tbody>
	<?php
	    $con=new mysqli("localhost","root","123456","FRT");
            $con->query("set character set 'utf8'");
	    if (!$con) { 
            die('数据库连接失败'.$mysqli_error()); 
        }
        $atID=null; 
        $atname=null; 
        $attime=null;
        $result=$con->query("select * from user_info;");//查出对应用户名的信息，isdelete表示在数据库已被删除的内容 
        while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来
        $atid=$row["id"];
        $atname=$row["username"]; 
        $atdelete=$row["isdelete"]; 
        ?>
                  <tr>
		    
			   <td><?php echo"$atid" ?></td>
			    <td><?php echo"$atname" ?></td>
			    <td><?php echo"$atdelete" ?></td>
                  </tr>
        <?php
	    }
	?>
	</tbody>
</table>
</div>

</body>
</html>
