<?php
/*********文件描述*********
 * @last      update 2015/12/4 9:33
 * @author    邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：自定义菜单
 * @author    邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version   2015/12/4 9:33
 */

namespace Weixin\Controller;

use Think\Controller;

class CustomMenuListController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cache = \Alibaba::cache();
        $this->token = $this->cache->get('ACCESS_TOKEN');
    }

//    自定义菜单创建
    public function customMenuListCreate()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->token;
        $btn['button'] = array(
            array('type' => 'click','name' => 'click事件','key' => 'clickEvent'),
            array('type' => 'view','name' => 'url跳转事件','url' => 'http://www.baidu.com'),
            array('name' => '子菜单','sub_button' => array(
                array('type' => 'view','name' => 'url跳转事件','url' => 'http://www.baidu.com'),
                array('type' => 'click','name' => 'click事件', 'key' => 'subClickEvent'),
                )
            ),
        );

        $chStr = chineseStringSave($btn); // json保存中文
        $res = http($url,$chStr,'post',true);
        dump($res);
    }
}