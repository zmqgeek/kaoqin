<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  
	<script src="type="text/javascript" src="js/jquery-1.12.3.min.js""></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>

<table class="table table-hover">
	<caption>所有考勤信息</caption>
	<thead>
		<tr>
			<th>学号</th>
			<th>姓名</th>
			<th>签到时间</th>
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
        $result=$con->query("select * from attendance;");//查出对应用户名的信息，isdelete表示在数据库已被删除的内容 
        while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来
        $atID=$row["ID"];
        $atname=$row["name"]; 
        $attime=$row["time"]; 
        ?>
                  <tr>
		    
			   <td><?php echo"$atID" ?></td>
			    <td><?php echo"$atname" ?></td>
			    <td><?php echo"$attime" ?></td>
                  </tr>
        <?php
	    }
	?>
	</tbody>
</table>
</div>

</body>
</html>

