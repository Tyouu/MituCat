<?php
    //实现模糊查询
    header("Content-Type:application/json;charset=utf-8");
    @$kw=$_REQUEST['kw'];
    if(empty($kw)){
        echo '[]';
        return;
    }
    require('init.php');
    $sql="SELECT did,price,img_sm,material,name FROM kf_dish WHERE name LIKE '%$kw%' or material LIKE '%$kw%'";
    $result=mysqli_query($conn,$sql);
    while(true){
            $row=mysqli_fetch_assoc($result);
            if(!$row){
                break;
            }
            $output[]=$row;
        }
        echo json_encode($output);
?>