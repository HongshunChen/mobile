<?php

//http://app.com/list.php?page=1&pagesize=12
require_once './DB.php';
require_once'./Response.php';
$page=  isset($_GET['page'])?$_GET['page']:1;
$pageSize=isset($_GET['pageSize'])?$_GET['pageSize']:1;
if(!is_numeric($page)||!is_numeric($pageSize)){
    return Response::show(401,"数据不合法");
}
$offset=($page-1)*$pageSize;
$sql="select * from t_user limit ".$offset.','.$pageSize;

$connect=DB::getInstance()->connect();
//var_dump($connect);


$result=mysql_query($sql,$connect);
//var_dump($result);
$rows=array();
while($row=  mysql_fetch_assoc($result)){
    $rows[]=$row;
}
//var_dump($rows);
if($rows){
    return Response::show(200, '首页获取数据成功', $rows);
}else{
    return Resonse::show(400,'首页数据获取失败');
}
