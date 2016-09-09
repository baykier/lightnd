<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 15:36
 */
namespace Baykier\Lightnd\Orm\Entity;

use \Spot\Entity;

class Word extends Entity
{
    protected static $table = 'ld_word';

    protected static $mapper = '\Baykier\Lightnd\Orm\Mapper\Word';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'integer','primary' => true,'autoincrement' => true),
            'source' => array('type' => 'string','required' => true),
            'target' => array('type' => 'string','required' => true),
            'length' => array('type' => 'string','required' => true),
            'keyword' => array('type' => 'string'),
            'created' => array('type' => 'integer'),
        );
    }
}