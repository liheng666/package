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

/**
 * 图片下载方法
 *@param string $dirname 储存文件夹地址
 *@param string $url 图片地址
 *@return array [bool,message]
 */
function download($dirname,$url)
{
    //获取图片信息
    $info = getimagesize($url);
    if(!$info){
        return [false,'获取图片信息失败'];
    }
    //图片格式
    $fix = explode('/', $info['mime'])[1];
    //打开输出控制缓冲
    ob_start();
    //读取文件并写入到输出缓冲
    readfile($url);
    //获取输出缓冲中的内容
    $file_contents = ob_get_contents();
    if(!$file_contents){
        return [false,'获取输出缓冲中的内容失败'];
    }
    //丢弃缓冲区的内容并摧毁缓冲区
    ob_end_clean();
    $filename = $dirname . uniqid() . '.' . $fix;
    if(file_put_contents($filename, $file_contents) === false){
        return [false,'图片输出失败'];
    }
    return [true,'ok'];
}
