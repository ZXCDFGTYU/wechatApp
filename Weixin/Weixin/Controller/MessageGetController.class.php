<?php
namespace Weixin\Controller;

use Think\Controller;

class MessageGetController extends Controller
{
//    public $cache;

    public function __construct()
    {
        parent::__construct();
        $this->cache = \Alibaba::cache();             // 实例化云引擎缓存
        $this->token = $this->cache->get('ACCESS_TOKEN'); // 获取ACCESS_TOKEN
        $this->msgRps = D('WeixinResponse');          // 实例化微信原始响应表
        $this->weixinText = D('WeixinText');          // 实例化微信文本消息表
        $this->weixinUrl = D('WeixinUrl');            // 实例化微信链接消息表
        $this->weixinVideo = D('WeixinVideo');        // 实例化微信视频表
        $this->weixinVoice = D('WeixinVoice');        // 实例化微信音频表
        $this->weixinSVideo = D('WeixinSVideo');      // 实例化微信小视频表
        $this->weixinPic = D('WeixinPic');            // 实例化微信图片消息表
        $this->weixinLocation = D('WeixinLocation');  // 实例化微信地理信息表
        $this->weixinUserInfo = D('WeixinUserInfo');// 实例化用户信息表
    }

//  接收用户发送的消息并写入微信原始响应表和对应类型的数据表
    public function messageGet($msg)
    {
        $data['content'] = xmlTojson($msg);  // xml消息转json
        $this->msgRps->create($data);
        $res['res'] = $this->msgRps->add() ? 'success' : false;
        $res['arr'] = json_decode(xmlToJson($msg), true);
        switch ($res['arr']['MsgType']) {
            case 'text':    // 文本消息
                $textData['from'] = $res['arr']['FromUserName']; // 发送方的openID
                $textData['content'] = $res['arr']['Content'];   // 文本内容
                $textData['create_time'] = $res['arr']['CreateTime']; // 消息的创建时间
                $this->weixinText->create($textData);
                $this->weixinText->add();
                break;
            case 'image': // 图片消息
                $imgData['from'] = $res['arr']['FromUserName'];
                $imgData['create_time'] = $res['arr']['CreateTime'];
                $imgData['imgurl'] = $res['arr']['PicUrl'];     // 图片在微信的url
                $imgData['mediaID'] = $res['arr']['MediaId'];   // 图片的mediaID
                $this->weixinPic->create($imgData);
                $this->weixinPic->add();
                break;
            case 'voice': // 语音消息
                $vData['from'] = $res['arr']['FromUserName'];
                $vData['format'] = $res['arr']['Format'];       // 音频格式
                $vData['mediaID'] = $res['arr']['MediaId'];
                $vData['create_time'] = $res['arr']['CreateTime'];
                $vData['recognition'] = $res['arr']['Recognition']; // 语音识别的文字结果
                $this->weixinVoice->create($vData);
                $this->weixinVoice->add();
                break;
            case 'video': // 视频消息
                $vData['from'] = $res['arr']['FromUserName'];
                $vData['create_time'] = $res['arr']['CreateTime'];
                $vData['mediaID'] = $res['arr']['MediaId'];     // 视频的媒体ID
                $vData['ThumbMediaID'] = $res['arr']['ThumbMediaId']; // 视频缩略图的媒体ID
                $this->weixinVideo->create($vData);
                $this->weixinVideo->add();
                break;
            case 'shortvideo': // 小视频消息
                $vData['from'] = $res['arr']['FromUserName'];
                $vData['create_time'] = $res['arr']['CreateTime'];
                $vData['mediaID'] = $res['arr']['MediaId']; // 小视频的媒体ID
                $vData['ThumbMediaID'] = $res['arr']['ThinkMediaId']; // 小视频缩略图的媒体ID
                $this->weixinSVideo->create($vData);
                $this->weixinSVideo->add();
                break;
            case 'location': // 地理位置消息
                $lData['from'] = $res['arr']['FromUserName'];
                $lData['create_time'] = $res['arr']['CreateTime'];
                $lData['x'] = $res['arr']['Location_X'];    // 纬度
                $lData['y'] = $res['arr']['Location_Y'];    // 经度
                $lData['scale'] = $res['arr']['Scale'];     // 地图缩放大小
                $lData['label'] = $res['arr']['Label'];     // 地理位置信息
                $this->weixinLocation->create($lData);
                $this->weixinLocation->add();
                break;
            case 'link': // 链接消息
                $linkData['from'] = $res['arr']['FromUserName'];
                $linkData['create_time'] = $res['arr']['CreateTime'];
                $linkData['title'] = $res['arr']['Title'];  // 链接标题
                $linkData['desc'] = $res['arr']['Description']; // 链接描述
                $linkData['url'] = $res['arr']['Url'];      // 链接url
                $this->weixinUrl->create($linkData);
                $this->weixinUrl->add();
                break;
            case 'event':
                // 事件类型消息解析
                if ($res['arr']['EventKey'] == 'clickEvent') { // 一级菜单click
                    $res['arr']['Content'] = '这是一个一级自定义菜单中的click事件';
                } elseif ($res['arr']['EventKey'] == 'subClickEvent') { // 二级菜单click
                    $res['arr']['Content'] = '这是一个二级自定义菜单中的click事件';
                } elseif ($res['arr']['Event'] == 'subscribe') { // 关注事件
                    $where['openid'] = $res['arr']['FromUserName'];
                    $isExists = $this->weixinUserInfo->where($where)->find();
                    if (!$isExists) {
                        $res['arr']['Content'] = '这是一个关注事件';
                        $data['openid'] = $res['arr']['FromUserName'];
                        $userInfo = $this->userInfoGet($res['arr']['FromUserName']); // 获取用户信息
                        $data['nickname'] = $userInfo['nickname']; // 获取昵称
                        $data['headimgurl'] = $userInfo['headimgurl']; // 获取头像
                        $data['subscribe_time'] = $userInfo['subscribe_time']; // 获取关注时间
                        $this->weixinUserInfo->create($data);
                        $this->weixinUserInfo->add();
                    } else {
                        $res['arr']['Content'] = '这是一个关注事件';
                        $data['update_time'] = time();
                        $data['status'] = '1';
                        $where['openid'] = $res['arr']['FromUserName'];
                        $this->weixinUserInfo->where($where)->save($data);
                    }
                } elseif ($res['arr']['Event'] == 'unsubscribe') { // 取消关注事件
                    $where['openid'] = $res['arr']['FromUserName'];
                    $data['update_time'] = time();
                    $data['status'] = '-1';
                    $this->weixinUserInfo->where($where)->save($data);
                }
                break;
        }

        return $res;
    }

//    关注事件获取用户信息
    private function userInfoGet($openID)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $this->token . '&openid=' . $openID . '&lang=zh_CN'; // 用户信息获取
        $res = http($url, '', 'get', true);

        return $res;
    }
}