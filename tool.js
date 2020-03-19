//1.冒泡排序
function bubbleSort(arr){
    for(i = 0; i < arr.length - 1; i++){
        for(j = 0; j < arr.length - i - 1; j++){
            if(arr[j] > arr[j + 1]){
                var tmp = arr[j];
                arr[j] = arr[j + 1];
                arr[j + 1] = tmp;
            }
        }
    }
}

//2.选择排序
function changeSort(arr){  //升序
    for(var i = 0; i < arr.length - 1; i++){
        for(var j = i + 1; j < arr.length; j++){
            if(arr[i] > arr[j]){
                var tmp = arr[i];
                arr[i] = arr[j];
                arr[j] = tmp;
            }
        }
    }
}

//3.选择排序
function changeSortDesc(arr){  //降序
    for(var i = 0; i < arr.length - 1; i++){
        for(var j = i + 1; j < arr.length; j++){
            if(arr[i] < arr[j]){
                var tmp = arr[i];
                arr[i] = arr[j];
                arr[j] = tmp;
            }
        }
    }
}

//4.n位验证码，每一个数字范围0~9
function numTestCode(n){
    var arr = [];
    for(var i = 0; i < n; i++){
        var num = parseInt(Math.random() * 10);
        arr.push(num);
    }
    return arr.join("");
}

//5.n位验证码，有字母有数字
function testCode(n){
    var arr = [];
    for(var i = 0; i < n; i++){
        var num = parseInt(Math.random() * 123);
        if(num >= 0 && num <= 9){
            arr.push(num);
        }else if(num >= 97 && num <= 122 || num >= 65 && num <= 90){
            arr.push(String.fromCharCode(num));
        }else{
            i--;
        }
    }
    return arr.join("");
}


function isABC(charStr){
    if(charStr >= "a" && charStr <= "z" || charStr >= "A" && charStr <= "Z"){
        return true;
    }else{
        return false;
    }
}

//判断单个字符是否是数字字母下划线
function isDEF(charStr){
    if(charStr >= "a" && charStr <= "z" || charStr >= "A" 
    && charStr <= "Z" || charStr >= "0" && charStr <= "9" || charStr == "_"){
        return true;
    }else{
        return false;
    }
}


//显示当前日期
function showTime(time){
    var d = new Date(time);
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var week = d.getDay();
    week = numOfChinese(week);

    var hour = doubleNum(d.getHours());
    var min = doubleNum(d.getMinutes());
    var sec = doubleNum(d.getSeconds());

    var str = year + "年" + month + "月" + day + "日 星期" + week + " " + hour +":" + min + ":" + sec;
    return str;
}

function numOfChinese(num){
    var arr = ["日", "一", "二", "三", "四", "五", "六"];
    return arr[num];
}


function doubleNum(n){
    if(n < 10){
        return "0" + n;
    }else{
        return n;
    }
}

//跨浏览器兼容获取当前css样式
function getStyle(node, cssStyle){
    return node.currentStyle ? node.currentStyle[cssStyle] : getComputedStyle(node)[cssStyle];
}

//生成随机颜色
function randomColor(){
    var str = "rgba("+ parseInt(Math.random() * 256) +","+ parseInt(Math.random() * 256) +","+ parseInt(Math.random() * 256) +",1)";
    return str;
}

//限制拖拽
function limitDrag(node){
    node.onmousedown = function(ev){
        var e = ev || window.event;
        var offsetX = e.clientX - node.offsetLeft;
        var offsetY = e.clientY - node.offsetTop;

        document.onmousemove = function(ev){
            var e = ev || window.event;
            var l = e.clientX - offsetX;
            var t = e.clientY - offsetY;
            var windowWidth = document.documentElement.clientWidth || document.body.clientWidth;
            var windowHeight = document.documentElement.clientHeight || document.body.clientHeight;

            //限制出界
            if(l <= 0){
                l = 0;
            }
            if(l >= windowWidth - node.offsetWidth){
                l = windowWidth - node.offsetWidth;
            }

            if(t <= 0){
                t = 0;
            }
            if(t >= windowHeight - node.offsetHeight){
                t = windowHeight - node.offsetHeight;
            }
            node.style.left = l + 'px';
            node.style.top = t + 'px';
        }
    }

    document.onmouseup = function(){
        document.onmousemove = null;
    }
}

//所有物体运动
function startMove(node, cssObj, complete){
    clearInterval(node.timer);
    node.timer = setInterval(function(){
        var isEnd = true;  //假设所有动画都到达目的值了，
        for(var attr in cssObj){
            var iTarget = cssObj[attr];
            //计算速度
            var iCur = null;
            if(attr == 'opacity'){
                iCur = parseInt(parseFloat(getStyle(node, 'opacity')) * 100);
            }else{
                iCur = parseInt(getStyle(node, attr));
            }
            var speed = (iTarget - iCur) / 8;
            speed = speed > 0 ? Math.ceil(speed) : Math.floor(speed);

            
                if(attr == 'opacity'){
                    iCur += speed;
                    node.style.opacity = iCur / 100;
                    node.style.filter = `alpha(opacity=${iCur})`;
                }else{
                    node.style[attr] = iCur + speed + 'px';
                }

                if(iCur != iTarget){
                    isEnd = false;
                }
            
        }

        if(isEnd){
            clearInterval(node.timer);
            if(complete){
                complete.call(node);
            }
        }
    }, 30);
}

//跨浏览器兼容获取当前css样式
function getStyle(node, cssStyle){
return node.currentStyle ? node.currentStyle[cssStyle] : getComputedStyle(node)[cssStyle];
}