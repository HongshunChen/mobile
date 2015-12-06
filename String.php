<?php



/**
 * 处理字符串的相关函数
 *
 * @author DOIT
 */
class String {
    /*
     utf8 截取的字节数按以下规律
     * 0xxx xxxx 1字节
     * 110x xxxx 2字节
     * 1110 xxxx 3字节
     * 1111 0xxx 4字节
     */
    /*截取字符
     * @author DOIT
     * @param string $str 要截取的字符串
     * @param int $len 要截取的字符个数
     */
    public function UTF8Sub($str,$len){
       if($len<=0){
           return '';
       } 
       $length=  strlen($str);//要截取的字符串字节数
       //先取字符串的第一个字节，substr是按字节来的
       $offset=0;//截取高位字节时的偏移量
       $chars=0;//截取到的字符数
       $res='';//截取的字符串
       while($chars<$len && $offset<$length){//只要还没有截取到$len长度就继续进行
           $high=  decbin(ord(substr($str, $offset, 1))); //取出每个字符的第一个字节转换成->十进制->二进制 进行判断高位字节
          // echo $high.'<br/>';
           if(strlen($high)<8){
               //截取1个字节
               $count=1;
           }else if(substr($high,0,3)=='110'){    //用字符串来判断，效率不高。使用位运算效果会更好
                                                        //110x xxxx &1110 0000 ->1100 0000
                                                        // 1110 xxxx &1111 0000 ->1110 0000
               $count=2;
           }else if(substr($high,0,4)=='1110'){
               $count=3;
           }else if(substr($high,0,5)=='11110'){
               $count=4;
           }else if(substr($high,0,6)=='111110'){
               $count=5;
           }else if(substr($high,0,7)=='1111110'){
               $count=6;
           }
          // echo $count.'<br/>';
           $res.=substr($str,$offset,$count);
           $chars+=1;
           $offset+=$count;
           
       }
       return $res;
    }
}

$str='他的人在呐，aAa这么大b是吗';
$string=new String();
echo $string->UTF8Sub($str, 8);