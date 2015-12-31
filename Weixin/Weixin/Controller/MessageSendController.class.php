<?php
/*********文件描述*********
 * @last      update 2015/12/3 9:45
 * @author    邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：消息群发Controller
 * @author    邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version   2015/12/3 9:45
 */

namespace Weixin\Controller;

use Think\Controller;
use Weixin\Model\WeixinResponseModel;

class MessageSendController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cache = \Alibaba::cache(); // 实例化云引擎缓存
        $this->token = $this->cache->get('ACCESS_TOKEN');
        $this->response = new WeixinResponseModel();
    }

//    依据openid组执行文本消息群发
    public function textGroupSend()
    {
        $token = $this->token;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=' . $token;
        $cont['touser'] = array('oISyswgLg57fmt6M0K_gISej63HY', 'oISyswpbf6KL91y2_lLDMamlx0lQ', 'oISyswrfniKWLAq48Q1XegGi8_1M', 'oISyswhfy5pZpVkcngSwU206N6pQ', 'oISyswof0EExLxYUszDaElPoTzbE', 'oISyswqeI8fAFf_RN3o9oFDlj_5g', 'oISyswh3Y0WpSpuK4tkSemTMMyyc'); // openID组
        $cont['msgtype'] = 'text';
        $cont['text'] = array(
            'content' => '不定时抽风测试~',
        );

        // 将中文转义后再还原
        array_walk_recursive($cont, function (&$v) {
            $v = urlencode($v);
        });

        $cont = urldecode(json_encode($cont));
        $res = json_decode(http($url, $cont, 'post', true), true);
        dump($res);
    }

//    依据openid组执行图文消息群发
    public function tuwenTextGroupSend(){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->token;
        $data = array(
            'touser' => array('oISyswgLg57fmt6M0K_gISej63HY','oISyswpbf6KL91y2_lLDMamlx0lQ','oISyswrfniKWLAq48Q1XegGi8_1M','oISyswhfy5pZpVkcngSwU206N6pQ','oISyswof0EExLxYUszDaElPoTzbE','oISyswqeI8fAFf_RN3o9oFDlj_5g','oISyswh3Y0WpSpuK4tkSemTMMyyc'),
            'mpnews' => array('media_id'=>'zpLJQP5eHVey6Vlcltuu6uF5ti908rJoRwMp1I3Vofc'),
            "msgtype" => "mpnews",
        );
        $res = http($url,json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),'post');
        echo $res;
        $this->response->create(array('content'=>$res));
        $this->response->add();
    }

//    发送模板消息
    public function templateMessageSend()
    {
        $token = $this->token;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token;
        $temp['touser'] = 'oISyswgLg57fmt6M0K_gISej63HY';
        $temp['template_id'] = '2fEe_qquorTi5z1Vau2-QU8kaL8XUka_BZuXg45JMVQ';   // 模板ID
        $temp['url'] = 'http://www.baidu.com';  // 当用户点击模板消息后跳转过去的链接
        $temp['data'] = array(
            'name' => array(
                'value' => 'Mr.Z',
                'color' => '#173177',
            ),
            'time' => array(
                'value' => date('Y-m-d H:i:s',time()),
                'color' => '#173177',
            ),
        );
        array_walk_recursive($temp,function(&$v){
            $v = urlencode($v);
        });

        $tempData = urldecode(json_encode($temp));
        $res = json_decode(http($url,$tempData,'post',true),true);
        dump($res);
    }
}