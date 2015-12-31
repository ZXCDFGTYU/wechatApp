<?php
/*********文件描述*********
 * @last update 2015/12/23 11:16
 * @author 邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：微信素材管理Model
 * @author 邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version 2015/12/23 11:16
 */

namespace Weixin\Model;

use Think\Model;

class WeixinResourceManagerModel extends Model
{
    protected $tableName = 'weixin_resource_manager';
    protected $_auto = array(
        array('create_time','time',self::MODEL_INSERT,'function'),
        array('status',1,self::MODEL_INSERT,'string'),
    );
}