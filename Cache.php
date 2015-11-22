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
    public function cacheData($key,$value='',$cacheTime=0){
       
        $filename=$this->dir.$key.self::EXT;
        if($value!==''){//将value 值写入缓存
             if(is_null($value)){//删除文件
            return @unlink($filename); //添加@防止不存在的时候返回false;
        }
            $dir=  dirname($filename);
            if(!is_dir($dir)){
                mkdir($dir, 0777);
            }
            $cacheTime=  sprintf("%011d",$cacheTime);
           return file_put_contents($filename, $cacheTime.json_encode($value));
        }
        if(!is_file($filename)){
            return false;
        }
        $contents=  file_get_contents($filename);
        $cacheTime=(int)  substr($contents,0,11);
        $value=substr($contents,11);
        if($cacheTime!=0 &&($cacheTime +  filemtime($filename))<time()){
            unlink($filename);
            return false;
          
        }
            return json_decode($value,true);
        
    }
}

