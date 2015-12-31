<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 11:40
 */

namespace Weixin\Controller;
use Think\Controller;

class TestController extends Controller {

    public function index(){
        $arr = array('aaaa'=>'中文');
        echo json_encode($arr,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
//        echo json_encode($arr);
    }

    public function timer(){
//        $t1 = strtotime('2015-12-21 14:29');
//        $t2 = strtotime('2015-12-24 14:29');
//        echo $t2-$t1; // 秒
//        echo '<br>';
//        echo ($t2-$t1)/3600; // 小时
//        echo '<br>';
//        echo ($t2-$t1)/3600/24; // 日
//        echo '<br>';
//        echo ($t2-$t1)/3600/24/7; // 周
//        echo '<br>';
//        echo ($t2-$t1)/3600/24/7/30; // 月
//        echo '<br>';
//        echo ($t2-$t1)/3600/24/7/30/12; // 年
        $t2 = date('His',time());
        echo $t2;
    }
}