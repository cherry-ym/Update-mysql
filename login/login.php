<?php
    header('content-type:text/html;charset="utf-8"');
    //统一返回格式
    $responseData = array("code" => 0, "message" => '');

    //1.取出数据
    $username = $_POST['username'];
    $password = $_POST['password'];

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

    //1.连接数据库
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

    //md5加密
    $str = md5(md5(md5($password)."yyy")."mmm");

    //5.准备sql语句 登录
    $sql = "SELECT * FROM users WHERE username='{$username}' AND password='{$str}'";

    //6.发送数据
    $res = mysql_query($sql);

    //7.取一行数据进行判断
    $row = mysql_fetch_assoc($res);
    //判断用户是否存在
    if(!$row){
        $responseData['code'] = 4;
        $responseData['message'] = '用户名或密码错误';
        echo json_encode($responseData);
    }else{
        $responseData['message'] = '登陆成功';
        echo json_encode($responseData);
    }

    mysql_close();
?>