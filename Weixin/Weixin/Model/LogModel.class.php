<?php
namespace Weixin\Model;
use Think\Model;

class LogModel extends Model {
    protected $tableName = 'weixin_log';
    protected $_auto = array(
        array('time','time',self::MODEL_INSERT,'function'),
        array('type','error'),
    );
}