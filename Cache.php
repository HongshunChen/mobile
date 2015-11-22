<?php
class Cache{
    private $dir='';
    const EXT='.txt'; //文件后缀
    public function __construct(){
        $this->dir=  dirname(__FILE__).'/files/';
    }
    /**
     * 生成获取删除缓存
     * @param type $key 文件名
     * @param type $value 要写入的值
     * @param type $path 路径
     */
    public function cacheData($key,$value='',$path=''){
       
        $filename=$this->dir.$path.$key.self::EXT;
        if($value!==''){//将value 值写入缓存
             if(is_null($value)){//删除文件
            return @unlink($filename); //添加@防止不存在的时候返回false;
        }
            $dir=  dirname($filename);
            if(!is_dir($dir)){
                mkdir($dir, 0777);
            }
           return file_put_contents($filename, json_encode($value));
        }
        if(!is_file($filename)){
            return false;
        }else{
            return json_decode(file_get_contents($filename),true);
        }
    }
}

