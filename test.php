<?php


require_once './Response.php';
require_once'./Cache.php';
$arr=array(
    'id'=>1,
    'name'=>'doit',
    'type'=>array(1,34,29)
);
//Response::json(200, 'sucess', $arr);
//Response::xmlEncode(200, 'sucess', $arr);
//Response::show(200, 'sucess', $arr,'xml');
$file=new Cache();
if($file->cacheData('cache','sjfjsjsjfj',180)){
    var_dump($file->cacheData('cache'));
    //echo "success";
}else{
    echo "error";
}