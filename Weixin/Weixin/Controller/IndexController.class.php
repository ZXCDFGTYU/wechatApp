<?php
/*********文件描述*********
 * @last update 2015/12/4 11:10
 * @author 邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：微信总调用入口
 * @author 邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version 2015/12/4 11:10
 */
namespace Weixin\Controller;

use Think\Controller;
use Weixin\Controller\MessageGetController;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> sign();
        $this->cache = \Alibaba::Cache();
    }

//    总调用
    public function index()
    {
        $msgGet = new MessageGetController();
        $msg = file_get_contents('php://input'); // 获取用户发过来的消息xml
        $res = $msgGet->messageGet($msg);        // 接收消息并写入
        if ($res['res']) {    // 判断接受结果，接到并成功写入则返回确认消息,否则false
            // 实现关键词回复 关键词为 嘿嘿嘿
            if ($res['arr']['Content'] == '嘿嘿嘿') { // 关键词回复
                $xml = '<xml><ToUserName><![CDATA[' . $res['arr']['FromUserName'] . ']]></ToUserName><FromUserName><![CDATA[' . $res['arr']['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[你追我，如果你追到我，你就把我嘿嘿嘿~]]></Content></xml>';
                echo $xml;
            } elseif ($res['arr']['Content']) { // 非关键词回复或指定内容回复 关注事件/click事件 ···
                $xml = '<xml><ToUserName><![CDATA[' . $res['arr']['FromUserName'] . ']]></ToUserName><FromUserName><![CDATA[' . $res['arr']['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[' . $res['arr']['Content'] . ']]></Content></xml>';
                echo $xml;
            }else{ // 无指定内容回复 Exception
                $xml = '<xml><ToUserName><![CDATA[' . $res['arr']['FromUserName'] . ']]></ToUserName><FromUserName><![CDATA[' . $res['arr']['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[已收到消息并回复此段文本]]></Content></xml>';
                echo $xml;
            }
        } else {
            $xml = '<xml><ToUserName><![CDATA[' . $res['arr']['FromUserName'] . '[]]></ToUserName><FromUserName><![CDATA[' . $res['arr']['ToUserName'] . ']]></FromUserName><CreateTime>' . time() . '</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[发生错误]]></Content></xml>';
            echo $xml;
        }
    }

//    验证消息真实性
    private function sign()
    {
        $sign = I('get.signature'); // 获取签名
        $token = '0531';    // token
        $stmp = I('get.timestamp'); // 时间戳
        $nonce = I('get.nonce'); // 随机数
        $echoStr = I('get.echostr'); // 随机字符串

        $arr = array($token, $stmp, $nonce);
        sort($arr, SORT_STRING);
        $tempStr = implode($arr);
        $tempStr = sha1($tempStr);
        if ($tempStr == $sign) {
            echo $echoStr;
        }
    }

//    获取AccessToken，通过ACE的定时任务自动执行
    public function cornGetAccessToken()
    {
        $appID = C('WEIXIN_BASE.APP_ID');
        $appSecret = C('WEIXIN_BASE.APP_SECRET');
        $tokenGet = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appID . '&secret=' . $appSecret;
        $res = json_decode(http($tokenGet, '', 'get', true), true);
        $this->cache->set('ACCESS_TOKEN', $res['access_token'], $res['expires_in']);
    }
}