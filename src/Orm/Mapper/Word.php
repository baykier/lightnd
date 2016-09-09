<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 15:50
 */
namespace Baykier\Lightnd\Orm\Mapper;

use \Spot\Mapper;

class Word extends Mapper
{
    public function addWord($word,$description,$keyword = '')
    {
        $entity = $this->create(array(
            'source' => $word,
            'target' => $description,
            'keyword' => $keyword,
            'created' => time(),
            'length' => mb_strlen($word)
        ));
        return $this->save($entity);
    }
    public function queryWord($word)
    {
        return $this->where(array('word' => $word))->first();
    }
}