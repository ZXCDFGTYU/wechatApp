<?php

/**
 * xml转json
 *
 * @param string $xml xml文本
 *
 * @return string json文本
 *
 * @author   邹广圆 中企动力移动产品业务部
 * @datetime 2015-12-01 13:30
 */
function xmlToJson($xml)
{
    $xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

    return json_encode($xmlObj);
}

/**
 * 执行curl请求
 *
 * @param string  $url    要请求的url地址
 * @param array   $param  要携带的参数
 * @param string  $method 请求类型 get/post
 * @param bool    $weixin 是否为微信请求
 *
 * @return string 返回值为字符串，请求成功返回请求之后获取的值，请求失败返回失败原因
 * @author   邹广圆 中企动力移动产品业务部
 * @datetime 2015-12-02 12:08
 */
function http($url, $param = array(), $method = 'get', $weixin = true)
{
    $xhr = curl_init();
    $xhrOpts = array(
        CURLOPT_HEADER         => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $url,
    );

//        判断method
    if ($method == 'get') {
        $xhrOpts[CURLOPT_HTTPGET] = 1;
    } else {
        $xhrOpts[CURLOPT_POST] = 1;
        if ($param) {
            //    判断是否携带参数
            $xhrOpts[CURLOPT_POSTFIELDS] = $param;
        }
    }

//        判断是否为微信请求
    if ($weixin) {
        $xhrOpts[CURLOPT_SSL_VERIFYPEER] = false;
        $xhrOpts[CURLOPT_SSL_VARIFYHOST] = false;
    }

    curl_setopt_array($xhr, $xhrOpts);
    $res = curl_exec($xhr);
    $dores = $res ? $res : curl_error($xhr);
    curl_close($xhr);

    return $dores;
}

/**
 * 中文字符串保存（作废）
 *
 * @param array $cont
 *
 * @return string
 * @author 邹广圆 中企动力移动产品业务部
 * @datetime 2015-12-22 10:15
 */
function chineseStringSave(array $cont)
{
    array_walk_recursive($cont, function (&$v) {
        $v = urlencode($v);
    });

    $res = json_encode($cont, JSON_UNESCAPED_SLASHES);

    return $res;
}

/**
 * 临时素材获取
 *
 * @param string $mediaID 素材的媒体ID
 * @param string $token   AccessToken
 *
 * @return bool 获取结果 获取成功返回true，否则false
 */
function tempResourceGetRequest($mediaID,$token){
//    素材获取接口
    $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$token.'&&media_id='.$mediaID;

//    curl初始化
    $xhr = curl_init();
    $xhrOpts = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_NOBODY => 0,
        CURLOPT_HTTPGET => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    );

    curl_setopt_array($xhr,$xhrOpts);
    $pak = curl_exec($xhr);
    curl_close($xhr);


//    文件生成，使用原生php写法
    $file = fopen('/ace/app/webroot/Public/Weixin/img/res.jpg','w');
    if(false !== $file){
        if(false !== fwrite($file,$pak)){
            fclose($file);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}