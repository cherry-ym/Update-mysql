<?php
    header('content-type:text/html;charset="utf-8"');
    //统一返回格式
    $responseData = array("code" => 0, "message" => '');

    //1.取出数据
    $username = $_POST['username'];
    $password = $_POST['password'];
    $addTime = $_POST['addTime'];

    //简单的表单验证
    if(!$username){
        $responseData['code'] = 1;
        $responseData['message'] = '用户名不能为空';
        echo json_encode($responseData);
        exit;
    }
    if(!$password){
        $responseData['code'] = 2;
        $responseData['message'] = '密码不能为空';
        echo json_encode($responseData);
        exit;
    }

    //连接数据库
    $link = mysql_connect("localhost", "root", "123456");

    //2.判断
    if(!$link){
        echo "连接失败";
        $responseData['code'] = 3;
        $responseData['message'] = '连接数据库失败';
        echo json_encode($responseData);
        exit;
    }

    //3.字符
    mysql_set_charset("utf8");

    //4.选择数据库
    mysql_select_db("ws");

    //5.准备sql语句  验证用户名是否重名
    $sql1 = "SELECT * FROM users WHERE username='{$username}'";

    //6.发送
    $res = mysql_query($sql1);

    //7.取一行数据
    $row = mysql_fetch_assoc($res);
    if($row){
        //用户名重名
        $responseData['code'] = 4;
        $responseData['message'] = '用户名已存在';
        echo json_encode($responseData);
        exit;
    }

    //md5加密
    $str = md5(md5(md5($password)."yyy")."mmm");

    //8.将sql语句插入数据库
    $sql2 = "INSERT INTO users(username,password,create_time) VALUES('{$username}','{$str}',{$addTime})";
    //返回布尔值
    $res = mysql_query($sql2);
    if(!$res){
        $responseData['code'] = 5;
        $responseData['message'] = '注册失败';
        echo json_encode($responseData);
    }else{
        $responseData['message'] = '注册成功';
        echo json_encode($responseData);
    }

    //9.关闭数据库
    mysql_close($link);
?>