<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/3
 * Time: 15:50
 */

namespace Weixin\Controller;

use Think\Controller;

class UserInfoGetController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cache = \Alibaba::cache();
        $this->token = $this->cache->get('ACCESS_TOKEN');
    }

//    获取当前公众号下所有粉丝的openid列表
//    并依据此openid列表查询对应的粉丝信息
    public function userInfoSave()
    {
        $openid = '';
        $userModel = D('WeixinUserInfo'); // 实例化用户信息Model
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $this->token; // 粉丝
        if (I('get.from')) {
            $url .= 'next_openid=' . I('get.from');
        }
        $openIDList = json_decode(http($url, '', 'get', true), true); // 获取OpenID列表
        $res = $this -> userInfoGet($openIDList);
        $datas = $res['user_info_list'];
        if($userModel -> addAll($datas)){
            echo '粉丝用户已写入数据库';
        }else{
            echo '粉丝用户写入数据库失败';
        }
    }

//    依据openID列表获取用户信息
    private function userInfoGet($openIDArr)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=' . $this->token;
        foreach($openIDArr['data']['openid'] as $v){ // 遍历openid数组到查询条件数组
            $data['user_list'][] = array(
                'openid' => $v,
                'lang' => 'zh-CN',
            );
        }

        $res = json_decode(http($url,json_encode($data),'post',true),true);
        return $res;
    }
}