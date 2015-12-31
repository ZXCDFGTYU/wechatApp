<?php
/*********文件描述*********
 * @last      update 2015/12/4 13:43
 * @author    邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：微信素材管理 创建、删除、修改、获取 临时/永久素材
 * @author    邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version   2015/12/4 13:43
 */

namespace Weixin\Controller;

use Weixin\Model\WeixinResponseModel;
use Think\Controller;
use Weixin\Model\LogModel;
use Weixin\Model\WeixinResourceManagerModel;

class ResourceManagerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cache = \Alibaba::cache();
        $this->storage = \Alibaba::storage('storage-01');
        $this->token = $this->cache->get('ACCESS_TOKEN');
        $this->log = new LogModel();
        $this->response = new WeixinResponseModel();
        $this->resource = new WeixinResourceManagerModel();
    }

//    临时素材创建 图片素材
    public function tempResourceCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->token . '&type=image';
        if (class_exists("CURLFile")) {
            $data = array(
                'media' => new \CURLFile(realpath('/ace/app/webroot/Public/Weixin/img/doge.jpg')),
            );
        } else {
            $data = array(
                'media' => '@' . realpath('/ace/app/webroot/Public/Weixin/img/doge.jpg'),
            );
        }

        $res = json_decode(http($url, $data, 'post', true), true);
        dump($res);
//        错误日志记录
        $res['url'] = __SELF__;
        $this->log->create($res);
        $this->log->add();
//        响应原文记录
        $repData['content'] = json_encode($res);
        $this->response->create($repData);
        $this->response->add();
    }

//    临时素材获取 图片素材
    public function tempResourceGet()
    {
        $mid = 'xc2wAXNf0iVhAcN4EBTDDQHdu2p3EIdLT2aA13aoBPKnyNgQwgWXVDJ2VW_JWU1V';
        $res = tempResourceGetRequest($mid, $this->token);
        dump($res);
    }

//    永久图文素材创建
    public function permanentResourceCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=' . $this->token;
        $data = array(
            'articles' => array(
                array(
                    'title' => '测试标题',
                    'thumb_media_id' => 'zpLJQP5eHVey6Vlcltuu6txkkrgLEp9pzY9jeWPvcHY',
                    'author' => 'doge',
                    'digest' => '我去我去我去我勒个去',
                    'show_cover_pic' => '1',
                    'content' => '测试内容测试内容<img src=https://mmbiz.qlogo.cn/mmbiz/QfYSPibpCgS6qRO3I2xxicicAV6oxyIicdG5dj8ySq3tZyicHFUKWsxz4RIdUh7SpHiaTacRhp16Ftd7D6LpLIicFGoeg/0?wx_fmt=jpeg>',
                    'content_source_url' => 'http://www.baidu.com',
                ),
            ),
        );

        $res = http($url,json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),'post');
        echo $res;
        $this->response->create(array('content'=>$res));
        $this->response->add();
        $arrRes = json_decode($res,true);
        $data['mediaid'] = $arrRes['media_id'];
        $data['type'] = '5';
        $this->resource->create($data);
        $this->response->add();
    }

//    其他类型的图文素材创建 图片/视频/音频/缩略图，当前是上传缩略图
    public function othPermanentResourceCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=' . $this->token;
        $data = array(
            'media' => '@/ace/app/webroot/Public/Weixin/img/doge.jpg',
            'type'  => 'thumb',
        );
        $resp = http($url, $data, 'post');
        echo $resp;
        $this->response->create(array('content' => $resp));
        $this->response->add();
        $response = json_decode($resp, true);
        $data['mediaid'] = $response['media_id'];
        $data['type'] = 2; // 缩略图
        $data['temp'] = 0; // 临时素材判断
        $data['url'] = $response['url']; // 图片url
        $this->resource->create($data);
        $this->resource->add();
    }

//    永久素材获取
    public function permanentResourceGet()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->token;
        $data = array('media_id'=>'zpLJQP5eHVey6Vlcltuu6uF5ti908rJoRwMp1I3Vofc');
        $res = http($url,json_encode($data),'post');
        echo stripslashes($res);
    }

//    永久素材删除
    public function permanentResourceDel()
    {
    }

//    素材列表获取
    public function resourceListGet(){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->token;
        $data = array(
            'type'=>'news',
            'offset'=>'0',
            'count'=>'20',
        );
    }
}