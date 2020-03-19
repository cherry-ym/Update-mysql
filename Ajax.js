function $ajax({method = "get", url, data, success, error}){
    //1.创建Ajax对象
    var xhr = null;
    try{
        xhr = new XMLHttpRequest();
    }catch(error){
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    //判断如果数据存在
    if(data){
        data = querystring(data);
    }

    //2.open()
    if(method == 'get' && data){
        url += '?' + data;
    }
    xhr.open(method, url, true);

    //3.send()
    if(method == 'get'){
        xhr.send();
    }else{
        //必须在send方法之前，去设置请求的格式
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhr.send(data);
    }

    //4.等待数据响应
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                /*
                如何去处理数据操作不确定，
                回调函数
                */
                if(success){
                    success(xhr.responseText);
                }
            }else{
                if(error){
                    error("Error:" + xhr.status);
                }
            }
        }
    }
}

function querystring(obj){
    var str = "";
    for(var attr in obj){
        str += attr + "=" + obj[attr] + "&";
    }
    return str.substring(0, str.length - 1);
}