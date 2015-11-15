<?php

class Response{
    const JSON='json';
    /*按json或xml方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 类型
     * @return string 
     * 
     */
    public static function show($code,$message,$data=array(),$type=self::JSON){
        if(!is_numeric($code)){
            return'';
        }
        $type=isset($_GET['format'])? $_GET['format']:self::JSON;
//        echo $type;
//        exit;
       $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ); 
       if($type=='json'){
           self::json($code, $message, $data);
           exit;
       }elseif($type=='array'){
           var_dump($result);
       }elseif($type=='xml'){
           self::xmlEncode($code, $message, $data);
           exit;
       }else{
           //.....
       }
    }
    
    /*按json方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @return string json格式数据
     * 
     */
    public static function json($code,$message,$data=array()){
        if(!is_numeric($code)){
            return'';
        }
        $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        echo json_encode($result);
        exit;
    }
    /*按xml方式输出通信数据(拼装成字符串或（DomDocument XMLWriter SimpleXML）)
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @return string xml格式数据
     * 
     */
    public static function xmlEncode($code,$message,$data=array()){
        if(!is_numeric($code)){
            return'';
        }
        $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        header("Content-Type:text/xml;");
        $xml="<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml.="<root>\n";
        $xml.=self::xmlToEncode($result);
        $xml.="</root>";
        echo $xml;
    }
    public static function xmlToEncode($data){
        $xml=$attr='';
        foreach ($data as $key => $value) {
            if(is_numeric($key)){
                $attr=" id='{$key}'";
                $key='item';
            }
            $xml.="<{$key}{$attr}>";
            $xml.=is_array($value)?self::xmlToEncode($value):$value;
            $xml.="</{$key}>\n";
            
        }
        return $xml;
    }
    
    
}

