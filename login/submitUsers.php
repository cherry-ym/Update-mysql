<?php
    header('content-type:text/html;charset="utf-8"');
    //统一返回格式
    $responseData = array("code" => 0, "message" => '');

    //1.取出数据
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];

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
    if(!$id){
        $responseData['code'] = 3;
        $responseData['message'] = '修改的用户不存在';
        echo json_encode($responseData);
        exit;
    }

    //连接数据库
    $link = mysql_connect("localhost", "root", "123456");

    //2.判断
    if(!$link){
        echo "连接失败";
        $responseData['code'] = 4;
        $responseData['message'] = '连接数据库失败';
        echo json_encode($responseData);
        exit;
    }

    //3.字符
    mysql_set_charset("utf8");

    //4.选择数据库
    mysql_select_db("ws");

    //5.准备sql语句  验证用户名是否重名
    $sql = "SELECT * FROM users WHERE username='{$username}' AND id!={$id}";

    $res = mysql_query($sql);
    $row = mysql_fetch_assoc($res);
    if($row){
        $responseData['code'] = 5;
        $responseData['message'] = '用户名重名，不能修改';
        echo json_encode($responseData);
        exit;
    }

    //md5加密
    $str = md5(md5(md5($password)."yyy")."mmm");

    $sql2 = "UPDATE users SET username='{$username}',password='{$password}' WHERE id={$id}";

    $res2 = mysql_query($sql2);

    if($res2){
        $responseData['message'] = '修改成功';
        echo json_encode($responseData);
    }else{
        $responseData['code'] = 6;
        $responseData['message'] = '修改失败，请重试';
        echo json_encode($responseData);
        exit;
    }

    
    //9.关闭数据库
    mysql_close($link);
?>