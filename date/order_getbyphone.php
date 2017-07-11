<?php
    //根据下单得到的手机号,得到该手机号的所有信息
    @$phone=$_REQUEST['phone'];
    //判断是否所有参赛都传递过来
    if(empty($phone)){
        echo '[]';
        return;
    }
    require('init.php');
    $sql="SELECT kf_order.oid,kf_dish.did,kf_dish.img_sm,kf_order.order_time,kf_order.user_name FROM kf_dish,kf_order WHERE kf_order.did=kf_dish.did AND kf_order.phone='$phone'";
    $result=mysqli_query($conn,$sql);
    $output=[];
    while(true){
        $row=mysqli_fetch_assoc($result);
        if(!$row){
             break;
        }
        $output[]=$row;
        }
        echo json_encode($output);
?>