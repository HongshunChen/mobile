<?php

// 让crontab定时执行的脚本程序     */5 * * * * /usr/bin/php /data/www/app/cron.php

// 想获取video中 6条数据

require_once('./db.php');
require_once('./Cache.php');

$sql = "select * from t_user";
try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	// $e->getMessage();
	file_put_contents('./logs/'.date('y-m-d') . '.txt' , $e->getMessage());
	return;
}
$result = mysql_query($sql, $connect); 
$rows = array();
while($row = mysql_fetch_assoc($result)) {
	$rows[] = $row;
}
$file = new Cache();
if($rows) {
	$file->cacheData('index_cron_cahce', $rows);
} else {
	file_put_contents('./logs/'.date('y-m-d') . '.txt' , "没有相关数据");
}
return;