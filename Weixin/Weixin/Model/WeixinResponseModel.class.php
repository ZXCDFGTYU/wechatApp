<?php
/*********文件描述*********
 * @last update 2015/11/30 16:31
 * @author 邹广圆 zouguangyuan@300.cn
 *
 *
 * 功能简介：
 * @author 邹广圆 zouguangyuan@300.cn
 * @copyright 中企动力vone+移动研发部
 * @version 2015/11/30 16:31
 */

namespace Weixin\Model;
use Think\Model;

class WeixinResponseModel extends Model
{
    protected $tableName = 'weixin_response';           // 指定表名
    protected $_auto = array(                           // 自动写入接收时间
        array('time','time',1,'function'),
    );
}