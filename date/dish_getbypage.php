<?php
    //实现数据添加
    header("Content-Type:application/json;charset=utf-8");
    //取到传递过来的参数
    @$start=$_REQUEST['start'];
    if(empty($start)){
        $start=0;
    }
    //从数据库中kf_dish表中的$start位置 读取5条数据回来
    //设置编号格式
    require('init.php');
    //执行查询
    $sql="select did,price,img_sm,material,name from kf_dish limit $start,5";
    $result=mysqli_query($conn,$sql);
    //var_dump($result);
    //取值 fetch_all fetch_assoc
    //从数据库返回的$result取结果 返回给客户端
    while(true){
        $row=mysqli_fetch_assoc($result);
        if(!$row){
            break;
        }
        $output[]=$row;
    }
    echo json_encode($output);
?>