<?php
    //将表单中用户输入的数据写入到kf_order
    header("Content-Type:application/json;charset=utf-8");
    @$user_name=$_REQUEST['user_name'];
    @$sex=$_REQUEST['sex'];
    @$phone=$_REQUEST['phone'];
    @$addr=$_REQUEST['addr'];
    @$did=$_REQUEST['did'];
    //判断是否所有参赛都传递过来
    if(empty($user_name)||empty($sex)||empty($phone)||empty($addr)||empty($did)){
        echo '[]';
        return;
    }
    //接收到该订单时的时间
    $order_time=time()*1000;
    require('init.php');
    $sql="INSERT INTO kf_order VALUES(null,'$phone','$user_name',$sex,'$order_time','$addr',$did)";
    $result=mysqli_query($conn,$sql);
    $output=[];
    if($result){
        $arr['msg']='success';
        $arr['oid']= mysqli_insert_id( $conn );
    }else{
        $arr['msg']='error';
    }
    echo json_encode($arr);
?>