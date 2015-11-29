<?php

//http://localhost/mobile/list.php?page=1&pageSize=12
require_once './DB.php';
require_once'./Response.php';
require_once'./Cache.php';

//直接从缓存中获取
$cache=new Cache();
$rows=$cache->cacheData('index_cron_cahce');
//var_dump($rows);
if ($rows) {
    return Response::show(200, '首页获取数据成功', $rows);
} else {
    return Response::show(400, '首页数据获取失败');
}

exit;

//数据库中获取或缓存获取
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 1;
if (!is_numeric($page) || !is_numeric($pageSize)) {
    return Response::show(401, "数据不合法");
}
$offset = ($page - 1) * $pageSize;
$sql = "select * from t_user limit " . $offset . ',' . $pageSize;
$cache = new Cache();
$rows = array();

if(!$rows=$cache->cacheData('cache'.$page.'-'.$pageSize)) {
    //echo 'fjsjfjsf';exit;
    try {
        $connect = DB::getInstance()->connect();
    } catch (Exception $exc) {
        return Response::show(403, '数据库连接失败');
        // echo $exc->getTraceAsString();
    }


//var_dump($connect);


    $result = mysql_query($sql, $connect);
//var_dump($result);
    
    while ($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    if($rows){
        $cache->cacheData('cache'.$page.'-'.$pageSize, $rows, 10);
    }
}

//var_dump($rows);
if ($rows) {
    return Response::show(200, '首页获取数据成功', $rows);
} else {
    return Resonse::show(400, '首页数据获取失败');
}
