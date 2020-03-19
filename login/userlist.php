<?php
    header('content-type:text/html;charset="utf-8"');
    //统一返回格式
    $responseData = array("code" => 0, "message" => '');

    //1.连接数据库
    $link = mysql_connect("localhost", "root", "123456");

    //2.判断
    if(!$link){
        echo "数据库连接失败";
        exit;
    }

    //3.字符
    mysql_set_charset("utf8");

    //4.选择数据库
    mysql_select_db("ws");

    //5.准备sql语句
    $sql = "SELECT * FROM users";

    //发送数据
    $res = mysql_query($sql);

    //取数据
    $arr = array();
    while($row = mysql_fetch_assoc($res)){
        array_push($arr, $row);
    }


    echo json_encode($arr);
    mysql_close($link);