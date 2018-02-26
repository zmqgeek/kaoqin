<!DOCTYPE html>  
    <html>    
      <head>    
            <meta charset="utf8">    
            <title>饼状图</title>
            <script src="js/d3.min.js" charset="utf8"></script>
      </head>   
    <div id="content" align="center">
    <center>
    <style>
   .tooltip{
        position: absolute;
        width: 120px;
        height: auto;
        font-family: simsun;
        font-size: 14px;
        text-align: center;
        color: white;
        border-width: 2px solid black;
        background-color: black;
        border-radius: 5px;
    }

    .tooltip:after{
        content: '';
        position: absolute;
        bottom: 100%;
        left: 20%;
        margin-left: 550px;
        width: 0;
        height: 0;
        border-bottom: 12px solid black;
        border-right: 12px solid transparent;
        border-left: 12px solid transparent;
    }

    </style>

    <?php
        $dataset=Array();
        $a=0;
        $con=new mysqli("localhost","root","123456","FRT");
            $con->query("set character set 'utf8'");
        if (!$con) { 
            die('数据库连接失败'.$mysqli_error()); 
        }
        $atname=null; 
        $atcount=null;
        $result=$con->query("select name,count(name) from attendance group by ID,name;");//查出对应用户名的信息，isdelete表示在数据库已被删除的内容 
        while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来
        $atname=$row["name"]; 
        $atcount=$row["count(name)"];
        $dataset[$a][0]=$atname;
        $dataset[$a][1]=$atcount;
        $a++;
    ?>
    <?php
        }
    ?>
<script type="text/javascript">
    var dataset=new Array();
    dataset=<?php echo json_encode($dataset); ?>;
    var width=600;  
    var height=600;  
    var svg=d3.select("#content")  
                .append("svg")  
                .attr("width",width)  
                .attr("height",height);
   // var dataset=[ ["小米",60.8] , ["三星",58.4] , ["联想",47.3] , ["苹果",46.6] ,  
     //                       ["华为",41.3] , ["酷派",40.1] ];  
      
    //转换数据  
    var pie=d3.layout.pie() //创建饼状图  
                .value(function(d){  
                    return d[1];  
                });//值访问器  
    //dataset为转换前的数据 piedata为转换后的数据  
    var piedata=pie(dataset);  
      
    //绘制  
    var outerRadius=width/3;  
    var innerRadius=0;//内半径和外半径  
      
    //创建弧生成器  
    var arc=d3.svg.arc()  
                .innerRadius(innerRadius)  
                .outerRadius(outerRadius);  
    var color=d3.scale.category20();  
    //添加对应数目的弧组  
    var arcs=svg.selectAll("g")  
                .data(piedata)  
                .enter()  
                .append("g")  
                .attr("transform","translate("+(width/2)+","+(height/2)+")");  
    //添加弧的路径元素  
    arcs.append("path")  
        .attr("fill",function(d,i){  
            return color(i);  
        })  
        .attr("d",function(d){  
            return arc(d);//使用弧生成器获取路径  
        });  
    //添加弧内的文字  
    arcs.append("text")  
        .attr("transform",function(d){  
            var x=arc.centroid(d)[0]*1.4;//文字的x坐标  
            var y=arc.centroid(d)[1]*1.4;  
            return "translate("+x+","+y+")";  
        })  
        .attr("text-anchor","middle")  
        .text(function(d){  
            //计算市场份额的百分比  
            var percent=Number(d.value)/d3.sum(dataset,function(d){  
                return d[1];  
            })*100;  
            //保留一位小数点 末尾加一个百分号返回  
            return percent.toFixed(1)+"%";  
        });  
    //添加连接弧外文字的直线元素  
    arcs.append("line")  
        .attr("stroke","black")  
        .attr("x1",function(d){  
            return arc.centroid(d)[0]*2;  
        })  
        .attr("y1",function(d){  
            return arc.centroid(d)[1]*2;  
        })  
        .attr("x2",function(d){  
            return arc.centroid(d)[0]*2.2;  
        })  
        .attr("y2",function(d){  
            return arc.centroid(d)[1]*2.2;  
        });  
      
    var fontsize=14;  
    arcs.append("line")  
        .style("stroke","black")  
        .each(function(d){  
            d.textLine={x1:0,y1:0,x2:0,y2:0};  
        })  
        .attr("x1",function(d){  
            d.textLine.x1=arc.centroid(d)[0]*2.2;  
            return d.textLine.x1;  
        })  
        .attr("y1",function(d){  
            d.textLine.y1=arc.centroid(d)[1]*2.2;  
            return d.textLine.y1;  
        })  
        .attr("x2",function(d){  
            // console.log("d.data[0]:  "+d.data[0]);//产商名  
            var strLen=getPixelLength(d.data[0],fontsize)*1.5;  
            var bx=arc.centroid(d)[0]*2.2;  
            d.textLine.x2=bx>=0?bx+strLen:bx-strLen;  
            return d.textLine.x2;  
        })  
        .attr("y2",function(d){  
            d.textLine.y2=arc.centroid(d)[1]*2.2;  
            return d.textLine.y2;  
        });  
      
      
      
    //添加弧外的文字元素  
    // arcs.append("text")  
    //  .attr("transform",function(d){  
    //      var x=arc.centroid(d)[0]*2.5;  
    //      var y=arc.centroid(d)[1]*2.5;  
    //      return "translate("+x+","+y+")";  
    //  })  
    //  .attr("text-anchor","middle")  
    //  .text(function(d){  
    //      return d.data[0];  
    //  });  
    arcs.append("text")  
        .attr("transform",function(d){  
            var x=0;  
            var y=0;  
            x=(d.textLine.x1+d.textLine.x2)/2;  
            y=d.textLine.y1;  
            y=y>0?y+fontsize*1.1:y-fontsize*0.4;  
            return "translate("+x+","+y+")";  
        })  
        .style("text-anchor","middle")  
        .style("font-size",fontsize)  
        .text(function(d){  
            return d.data[0];  
        });  
      
    //添加一个提示框  
    var tooltip=d3.select("body")  
                    .append("div")  
                    .attr("class","tooltip")  
                    .style("opacity",0.0);  
      
    arcs.on("mouseover",function(d,i){  
                    /* 
                    鼠标移入时， 
                    （1）通过 selection.html() 来更改提示框的文字 
                    （2）通过更改样式 left 和 top 来设定提示框的位置 
                    （3）设定提示框的透明度为1.0（完全不透明） 
                    */  
        console.log(d.data[0]+"的出勤次数为"+"<br />"+d.data[1]+" 次")  
        tooltip.html(d.data[0]+"的出勤次数为"+"<br />"+d.data[1]+" 次")
            .style("left",(d3.event.pageX)+"px")  
            .style("top",(d3.event.pageY+20)+"px")  
            .style("opacity",1.0);  
        tooltip.style("box-shadow","10px 0px 0px"+color(i));//在提示框后添加阴影  
        })  
        .on("mousemove",function(d){  
            /* 鼠标移动时，更改样式 left 和 top 来改变提示框的位置 */  
            tooltip.style("left",(d3.event.pageX)+"px")  
                    .style("top",(d3.event.pageY+20)+"px");  
        })  
        .on("mouseout",function(d){  
            //鼠标移除 透明度设为0  
            tooltip.style("opacity",0.0);  
        })  
      
        function getPixelLength(str,fontsize){  
            var curLen=0;  
            for(var i=0;i<str.length;i++){  
                var code=str.charCodeAt(i);  
                var pixelLen=code>255?fontsize:fontsize/2;  
                curLen+=pixelLen;  
            }  
            return curLen;  
        }  
    </script>
    </center>
    </div>   
      
    </html>  
