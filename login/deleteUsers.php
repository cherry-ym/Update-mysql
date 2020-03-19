<?php
    header('content-type:text/html;charset="utf-8"');
    //统一返回格式
    $responseData = array("code" => 0, "message" => '');

    //拿到要删除的数据
    $id = $_GET['id'];
    //1.连接数据库
    $link = mysql_connect("localhost", "root", "123456");

    //2.判断
    if(!$link){
        $responseData['code'] = 1;
        $responseData['message'] = '数据库连接失败';
        echo json_encode($responseData);
        exit;
    }

    //3.字符
    mysql_set_charset("utf8");

    //4.选择数据库
    mysql_select_db("ws");

    //5.准备sql语句
    $sql = "DELETE FROM users WHERE id={$id}";

    $res = mysql_query($sql);
    if(!$res){
        $responseData['code'] = 2;
        $responseData['message'] = '数据删除失败';
        echo json_encode($responseData);
    }else{
        
        $responseData['message'] = '数据删除成功';
        echo json_encode($responseData);
    }

    mysql_close($link);
?>