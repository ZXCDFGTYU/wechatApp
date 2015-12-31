<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/3
 * Time: 15:58
 */

namespace Weixin\Model;
use Think\Model;

class WeixinUserInfoModel extends Model {
    protected $tableName = 'weixin_get_user_info';
    protected $_auto = array(
        array('status','1',self::MODEL_INSERT,'string'), // 关注时设置status字段值为1
        array('update_time','time',self::MODEL_INSERT,'function'), // 关注时设置update_time字段值为time()
    );
}