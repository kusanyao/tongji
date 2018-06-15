(function(){
    // 配置
    var conf = {
        dhost:'http://tongji.kusanyao.com/tongji.php',
        guidCookieName:'KSYGUID'
    };
    var param = {
        count:0
    };

    // document对象数据
    if(document){
        param.domain = document.domain   || '';
        param.url    = document.URL      || '';
        param.title  = document.title    || '';
        param.ref    = document.referrer || '';
        if(document.cookie != undefined){
            var arrcookie = document.cookie.split("; ");
            // 遍历匹配
            for ( var i = 0; i < arrcookie.length; i++) {
                var arr = arrcookie[i].split("=");
                if (arr[0] == conf.guidCookieName){
                    param.guid = arr[1];
                    break;
                }
            }
            if(!param.guid){
                param.guid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                    return v.toString(16);
                });
                var expires = new Date(new Date().setHours(23,  59, 59, 999)).toGMTString();
                document.cookie = conf.guidCookieName + "="+ param.guid + ";expires=" + expires;
            }
        }
    }    

    // window对象数据
    if(window && window.screen){
        param.sh = window.screen.height     || 0;
        param.sw = window.screen.width      || 0;
        param.cd = window.screen.colorDepth || 0;
    }

    // navigator对象数据
    if(navigator){
        param.ua   = navigator.userAgent || '';
        param.pf   = navigator.platform  || '';
        param.lang = navigator.language  || '';
    }

    // 构建查询字符串
    function getQueryString(param){
        var args = '';
        for (var i in param) {
            if(args != ''){
                args += '&';
            }
            args += i + '=' + encodeURIComponent(param[i]);
        }
        return args;
    }

    // 通过Image对象请求后端脚本
    var img = (new Image(1, 1)).src = conf.dhost + '?' + getQueryString(param);
    setInterval(function(){
        param.count++;
        var img = (new Image(1, 1)).src = conf.dhost + '?' + getQueryString(param);
    }, 60000);
})()
