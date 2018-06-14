<?php
/**
 * 配置
 */
$conf = array(
    'db' => array(
        'dsn'      => 'mysql:dbname=tongji;host=127.0.0.1',
        'username' => 'kusanyao',
        'password' => 'kusanyao',
        'table'    => 'tongji'
    ),
);

/**
 * 不同环境下获取真实的IP
 */
function getIp(){
    // 判断服务器是否允许$_SERVER
    if(isset($_SERVER)){    
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }else{
        // 不允许就使用getenv获取  
        if(getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        }else{
            $realip = getenv("REMOTE_ADDR");
        }
    }
    $intip = ip2long($realip);
    if($intip == "-1") { 
       return false; 
    }
    return intval(sprintf("%u", $intip));
}

function input($key){
    $val = null;
    if(isset($_POST[ $key ])){
        $val = $_POST[ $key ];
    }
    if(isset($_GET[ $key ])){
        $val = $_GET[ $key ];
    }
    if($val != null){
        $val = trim($val);
    }
    return $val;
}

/**
 * 过滤数据
 */
function getData(){
    $data = array(
        'domain'     => input('domain'),
        'url'        => input('url'),
        'title'      => input('title'),
        'referrer'   => input('ref'),
        'height'     => input('sh'),
        'width'      => input('sw'),
        'colordepth' => input('cd'),
        'useragent'  => input('ua'),
        'platform'   => input('pf'),
        'language'   => input('lang'),
        'guid'       => input('guid'),
        'count'      => input('count'),
    );
    return $data;
}


/**
 * 写入数据
 */
function insert($conf, $data){
    $insertData = [];
    $insertSql  = '';
    foreach ($data as $key => $value) {
        if($insertSql != ''){
            $insertSql .= ',';
        }
        $insertSql .= '`' . $key . '`=:' . $key;
        $insertData[':' . $key] = $value;
    }
    $insertSql = 'insert `' . $conf['table'] . '` set ' . $insertSql;
    try{
        $dbh = new PDO($conf['dsn'], $conf['username'], 'kusanyao');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare($insertSql);
        $res  = $stmt->execute($insertData);
        if($res){
            return $dbh->lastinsertid();
        }        
    }catch(Exception $e){
        die('数据库连接失败:' . $e->getMessage());
    }
}

if(empty($_GET['domain'])){
    return;
}

$data = getData();

$data['ip']         = getIp();
$data['created_at'] = time();

$id = insert($conf['db'], $data);
