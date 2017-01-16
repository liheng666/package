<?php 

/**
*sign 生成签名
*
*@param array $data
*@param string key
*@return string 
*/
function sign(array $data, $key)
{

	//参数排序
    $data = arsort($data);
    //去除空值参数
    $data = array_filter($data, function($v){
        if(empty($v)){
            return false;
        }
        return true;
    });
    $sign = MD5(MD5(http_build_query($data) . $key));
    return $sign;
}