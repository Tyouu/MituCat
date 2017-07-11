<?php
    //根据菜品id查询详情
    header("Content-Type:application/json;charset=utf-8");
    //取到传递过来的参数
    @$did=$_REQUEST['did'];
    if(empty($did)){
        echo '[]';
        return;
    }
    require('init.php');
    //执行查询
    $sql="select did,name,img_lg,detail,material,price from kf_dish WHERE did=$did";
    $result=mysqli_query($conn,$sql);
    //取值 fetch_all fetch_assoc
    //从数据库返回的$result取结果 返回给客户端
    $row=mysqli_fetch_assoc($result);
    if(empty($row)){
        echo '[]';
    }else{
        $output[]=$row;
        echo json_encode($output);
    }
?>